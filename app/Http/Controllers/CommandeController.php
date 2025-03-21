<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\AricleCommande;
use App\Models\Article;
use App\Models\Categorie;
use App\Models\Client;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $commandes = Commande::with(['client'])->latest();

            return DataTables::of($commandes)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" name="commande_checkbox" class="commande_checkbox form-check-input" value="' . $row->id . '" />';
                })
                ->addColumn('client', function ($row) {
                    return $row->client ? $row->client->Nom : 'N/A';
                })
                ->addColumn('actions', function ($row) {
                    return '<div class="d-flex align-items-center">
                    <a href="' . route('commandes.show', $row->id) . '" class="btn btn-info me-2 buttontr d-flex align-items-center">
                        <i class="mdi mdi-eye mx-auto"></i>
                    </a>
                    <a href="' . route('commandes.edit', $row->id) . '" class="btn btn-primary me-2 buttontr d-flex align-items-center">
                        <i class="mdi mdi-pencil mx-auto"></i>
                    </a>
                    <button class="btn btn-danger delete-commande me-2 buttontr d-flex align-items-center" data-id="' . $row->id . '">
                        <i class="mdi mdi-delete mx-auto"></i>
                    </button>
                    <a href="' . route('commandes.pdf', $row->id) . '" class="btn btn-success me-2 buttontr d-flex align-items-center" target="_blank">
                        <i class="mdi mdi-file-pdf mx-auto"></i>
                    </a>
                    </div>';
                })
                ->rawColumns(['checkbox', 'actions'])
                ->make(true);
        }

        return view('commandes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Client::all();
        $articles = Article::all();
        $categories = Categorie::all();
        return view('commandes.create', compact('clients', 'articles', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'reference' => 'nullable|string|max:255',
            'client_id' => 'required|exists:clients,id',
            'subtotal' => 'nullable|numeric|min:0',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'tax_amount' => 'nullable|numeric|min:0',
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

        try {
            // Create new commande
            $commande = new Commande();
            $commande->date = $request->date;
            $commande->reference = $request->reference;
            $commande->client_id = $request->client_id;
            $commande->subtotal = $request->subtotal ?? 0;
            $commande->tax_rate = $request->tax_rate ?? 20;
            $commande->tax_amount = $request->tax_amount ?? 0;
            $commande->total = $request->total;
            $commande->paye = $request->paye;
            $commande->du = $request->du;
            $commande->notes = $request->notes;
            $commande->save();

            // Create article relationships
            if (isset($request->articles) && is_array($request->articles)) {
                foreach ($request->articles as $articleData) {
                    if (!isset($articleData['article_id']) || !isset($articleData['Quantite']) || !isset($articleData['CustomPrix'])) {
                        continue; // Skip invalid entries
                    }

                    $commandeArticle = new AricleCommande();
                    $commandeArticle->commande_id = $commande->id;
                    $commandeArticle->article_id = $articleData['article_id'];
                    $commandeArticle->Quantite = $articleData['Quantite'];
                    $commandeArticle->CustomPrix = $articleData['CustomPrix'];
                    $commandeArticle->save();
                }
            }

            DB::commit();

            return redirect()->route('commandes.index')
                ->with('success', 'Commande créé avec succès');
        } catch (\Exception $e) {
            DB::rollback();

            dd($e->getMessage());

            return redirect()->back()
                ->with('error', 'Une erreur est survenue: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $commande = Commande::with([
            'articles.article',
            'client'
        ])->findOrFail($id);

        return view('commandes.show', compact('commande'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $commande = Commande::findOrFail($id);
        $clients = Client::orderBy('Nom')->get();
        $categories = Categorie::orderBy('NomeCategorie')->get();
        $commandeArticles = AricleCommande::where('commande_id', $id)
            ->with('article')
            ->get();
        
        return view('commandes.edit', compact('commande', 'clients', 'categories', 'commandeArticles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'reference' => 'nullable|string|max:255',
            'client_id' => 'required|exists:clients,id',
            'subtotal' => 'nullable|numeric|min:0',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'tax_amount' => 'nullable|numeric|min:0',
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

        try {
            // Update commande
            $commande = Commande::findOrFail($id);
            $commande->date = $request->date;
            $commande->reference = $request->reference;
            $commande->client_id = $request->client_id;
            $commande->subtotal = $request->subtotal;
            $commande->tax_rate = $request->tax_rate;
            $commande->tax_amount = $request->tax_amount;
            $commande->total = $request->total;
            $commande->paye = $request->paye;
            $commande->du = $request->du;
            $commande->notes = $request->notes;
            $commande->save();

            // Delete existing article relationships
            AricleCommande::where('commande_id', $commande->id)->delete();

            // Create new article relationships
            if (isset($request->articles) && is_array($request->articles)) {
                foreach ($request->articles as $articleData) {
                    if (!isset($articleData['article_id']) || !isset($articleData['Quantite']) || !isset($articleData['CustomPrix'])) {
                        continue; // Skip invalid entries
                    }

                    $commandeArticle = new AricleCommande();
                    $commandeArticle->commande_id = $commande->id;
                    $commandeArticle->article_id = $articleData['article_id'];
                    $commandeArticle->Quantite = $articleData['Quantite'];
                    $commandeArticle->CustomPrix = $articleData['CustomPrix'];
                    $commandeArticle->save();
                }
            }

            DB::commit();

            return redirect()->route('commandes.index')
                ->with('success', 'Commande mis à jour avec succès');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $commande = Commande::findOrFail($id);
        $commande->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('commandes.index')
            ->with('success', 'Commande supprimé avec succès');
    }

    /**
     * Remove multiple resources from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function multiDelete(Request $request)
    {
        $commande_ids = $request->input('commande_ids');

        if (!$commande_ids) {
            return response()->json(['success' => false, 'message' => 'No commandes selected']);
        }

        Commande::whereIn('id', $commande_ids)->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Generate PDF for the specified commande.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function generatePDF($id)
    {
        $commande = Commande::with([
            'articles.article',
            'client'
        ])->findOrFail($id);

        $pdf = FacadePdf::loadView('commandes.pdf', compact('commande'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('commande-' . $commande->id . '-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Search for articles by name or barcode.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchArticles(Request $request)
    {
        $term = $request->input('term');
        $page = $request->input('page', 1);
        $perPage = 10;

        $articles = Article::where('Nome', 'LIKE', "%{$term}%")
            ->orWhere('barcode', 'LIKE', "%{$term}%")
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'articles' => $articles->items(),
            'pagination' => [
                'more' => $articles->hasMorePages()
            ]
        ]);
    }
}
