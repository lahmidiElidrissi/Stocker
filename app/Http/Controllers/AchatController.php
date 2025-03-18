<?php
// app/Http/Controllers/AchatController.php

namespace App\Http\Controllers;

use App\Models\Achat;
use App\Models\achatArticle;
use App\Models\article;
use App\Models\Categorie;
use App\Models\Contenir;
use App\Models\Fournisseur;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class AchatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $achats = Achat::with(['contenir', 'fournisseur'])->latest();

        if ($request->ajax()) {
            $achats = Achat::with(['contenir', 'fournisseur'])->latest();

            return DataTables::of($achats)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" name="achat_checkbox" class="achat_checkbox form-check-input" value="' . $row->id . '" />
                            <i class="input-helper"></i>';
                })
                ->addColumn('fournisseur', function ($row) {
                    return $row->fournisseur ? $row->fournisseur->Nom : 'N/A';
                })
                ->addColumn('actions', function ($row) {
                    return '<div class="d-flex align-items-center">
                    <a href="' . route('achats.show', $row->id) . '" class="btn btn-primary me-2 buttontr d-flex align-items-center">
                        <i class="mdi mdi-eye mx-auto"></i>
                    </a>
                    <a href="' . route('achats.edit', $row->id) . '" class="btn btn-success me-2 buttontr d-flex align-items-center">
                        <i class="mdi mdi-pencil mx-auto"></i>
                    </a>
                    <button class="btn btn-danger delete-achat me-2 buttontr d-flex align-items-center" data-id="' . $row->id . '">
                        <i class="mdi mdi-delete mx-auto"></i>
                    </button>
                    </div>';
                })
                ->rawColumns(['checkbox', 'actions'])
                ->make(true);
        }

        return view('achats.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $contenirs = Contenir::all();
        $fournisseurs = Fournisseur::all();
        $products = Article::all();
        $categories = Categorie::all();
        return view('achats.create', compact('contenirs', 'fournisseurs', 'products', 'categories'));
    }

    /**
     * Store a newly created purchase in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'Referance' => 'nullable|string|max:255',
            'fournisseur_id' => 'nullable|exists:fournisseurs,id',
            'contenir_id' => 'nullable|exists:contenirs,id',
            'total' => 'required|numeric|min:0',
            'paye' => 'required|numeric|min:0',
            'du' => 'required|numeric',
            'articles' => 'required|array',
            'articles.*.article_id' => 'required|exists:articles,id',
            'articles.*.Quantite' => 'required|numeric|min:1',
            'articles.*.CustomPrix' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        // Create new achat
        $achat = new Achat();
        $achat->date = $request->date;
        $achat->Referance = $request->Referance;
        $achat->fournisseur_id = $request->fournisseur_id;
        $achat->contenir_id = $request->contenir_id;

        // Set the tax fields if they exist in the table
        if (Schema::hasColumn('achats', 'subtotal')) {
            $achat->subtotal = $request->subtotal ?? 0;
        }

        if (Schema::hasColumn('achats', 'tax_rate')) {
            $achat->tax_rate = $request->tax_rate ?? 20;
        }

        if (Schema::hasColumn('achats', 'tax_amount')) {
            $achat->tax_amount = $request->tax_amount ?? 0;
        }

        $achat->total = $request->total;
        $achat->paye = $request->paye;
        $achat->du = $request->du;
        $achat->save();

        // Create article relationships
        if (isset($request->articles) && is_array($request->articles)) {
            foreach ($request->articles as $articleData) {
                if (!isset($articleData['article_id']) || !isset($articleData['Quantite']) || !isset($articleData['CustomPrix'])) {
                    continue; // Skip invalid entries
                }

                $achatArticle = new AchatArticle();
                $achatArticle->achat_id = $achat->id;
                $achatArticle->article_id = $articleData['article_id'];
                $achatArticle->Quantite = $articleData['Quantite'];
                $achatArticle->prix = $articleData['CustomPrix'];
                $achatArticle->save();
            }
        }

        DB::commit();

        return redirect()->route('achats.index')
            ->with('success', 'Achat créé avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Achat  $achat
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $achat = Achat::with([
            'articles.article',
            'fournisseur',
            'contenir'
        ])->findOrFail($id);

        return view('achats.show', compact('achat'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Achat  $achat
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Get achat with its related articles
        $achat = Achat::with(['articles.article'])->findOrFail($id);

        // Get all suppliers, containers and categories for dropdown menus
        $fournisseurs = Fournisseur::all();
        $contenirs = Contenir::all();
        $categories = Categorie::all();

        return view('achats.edit', compact('achat', 'fournisseurs', 'contenirs', 'categories'));
    }

    public function update(Request $request, $id)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'Referance' => 'nullable|string|max:255',
            'fournisseur_id' => 'nullable|exists:fournisseurs,id',
            'contenir_id' => 'nullable|exists:contenirs,id',
            'subtotal' => 'required|numeric|min:0',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'tax_amount' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'paye' => 'required|numeric|min:0',
            'du' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Update achat
            $achat = Achat::findOrFail($id);
            $achat->date = $request->date;
            $achat->Referance = $request->Referance;
            $achat->fournisseur_id = $request->fournisseur_id;
            $achat->contenir_id = $request->contenir_id;
            $achat->subtotal = $request->subtotal;
            $achat->tax_rate = $request->tax_rate;
            $achat->tax_amount = $request->tax_amount;
            $achat->total = $request->total;
            $achat->paye = $request->paye;
            $achat->du = $request->du;
            $achat->save();

            // Delete existing article relationships
            achatArticle::where('achat_id', $achat->id)->delete();

            // Create new article relationships
            if (isset($request->articles) && is_array($request->articles)) {
                foreach ($request->articles as $articleData) {
                    $achatArticle = new achatArticle();
                    $achatArticle->achat_id = $achat->id;
                    $achatArticle->article_id = $articleData['article_id'];
                    $achatArticle->Quantite = $articleData['Quantite'];
                    $achatArticle->prix = $articleData['CustomPrix'];
                    $achatArticle->save();
                }
            }

            DB::commit();

            return redirect()->route('achats.index')
                ->with('success', 'Achat mis à jour avec succès');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->with('error', 'Une erreur est survenue: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Achat  $achat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Achat $GestionDesAchat)
    {
        $GestionDesAchat->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('achats.index')->with('success', 'Achat supprimé avec succès');
    }

    /**
     * Remove multiple resources from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function multiDelete(Request $request)
    {
        $achat_ids = $request->input('achat_ids');
        Achat::whereIn('id', $achat_ids)->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Generate PDF for the specified purchase.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function generatePDF($id)
    {
        // Get achat with its related articles and article details
        $achat = Achat::with([
            'articles.article',
            'fournisseur',
            'contenir'
        ])->findOrFail($id);

        // Generate the PDF
        $pdf = FacadePdf::loadView('achats.pdf', compact('achat'));

        // Optional: Set paper size and orientation
        $pdf->setPaper('a4', 'portrait');

        // Download the PDF with a custom filename
        return $pdf->download('achat-' . $achat->id . '-' . date('Y-m-d') . '.pdf');
    }
}
