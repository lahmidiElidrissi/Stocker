<?php

namespace App\Http\Controllers;

use App\Models\Achat;
use App\Models\AchatArticle;
use App\Models\Article;
use App\Models\Categorie;
use App\Models\Category;
use App\Models\Fournisseur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $articles = Article::with('categorie')->select('articles.*');

            return DataTables::of($articles)
                ->addColumn('checkbox', function ($article) {
                    return '<input type="checkbox" class="dt-checkboxes" value="' . $article->id . '">';
                })
                ->addColumn('image', function ($article) {
                    return $article->image
                        ? '<img src="' . asset($article->image) . '" class="article-thumbnail">'
                        : '<img src="' . asset('images/no-image.png') . '" class="article-thumbnail">';
                })
                // Add this line to properly display the category name
                ->editColumn('categorie', function ($article) {
                    return $article->categorie->NomeCategorie ?? 'N/A';
                })
                ->addColumn('stock', function ($article) {
                    $stock = $article->stock;
                    if ($stock <= 0) {
                        return '<span class="badge bg-danger">' . $stock . '</span>';
                    } else if ($stock < 10) {
                        return '<span class="badge bg-warning">' . $stock . '</span>';
                    } else {
                        return '<span class="badge bg-success">' . $stock . '</span>';
                    }
                })
                ->addColumn('action', function ($article) {
                    return '<div class="d-flex align-items-center">
                        <a href="' . route('articles.show', $article->id) . '" class="btn btn-info me-2 buttontr d-flex align-items-center">
                            <i class="mdi mdi-eye mx-auto"></i>
                        </a>
                        <a href="' . route('articles.edit', $article->id) . '" class="btn btn-primary me-2 buttontr d-flex align-items-center">
                            <i class="mdi mdi-pencil mx-auto"></i>
                        </a>
                        <button class="btn btn-danger delete-article me-2 buttontr d-flex align-items-center" data-id="' . $article->id . '">
                            <i class="mdi mdi-delete mx-auto"></i>
                        </button>
                    </div>';
                })
                ->rawColumns(['checkbox', 'image', 'action', 'stock'])
                ->make(true);
        }

        return view('articles.index');
    }

    public function create()
    {
        $categories = Categorie::all();
        return view('articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'Nome' => 'required|string|max:255',
            'Prix' => 'nullable|numeric|min:0',
            'prix_gros' => 'nullable|numeric|min:0',
            'prix_achat' => 'nullable|numeric|min:0',
            'prix_importation' => 'nullable|numeric|min:0',
            'Referance' => 'nullable',
            'categorie_id' => 'nullable',
            'barcode' => 'nullable',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('images/articles');

            // Make sure the directory exists
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $image->move($destinationPath, $imageName);
            $validatedData['image'] = 'images/articles/' . $imageName;
        }

        Article::create($validatedData);

        return redirect()->route('articles.index')
            ->with('success', 'Article créé avec succès.');
    }

    public function edit(Article $article)
    {
        $categories = Categorie::all();
        return view('articles.edit', compact('article', 'categories'));
    }

    public function show($id)
    {
        $article = Article::with(['categorie'])->findOrFail($id);
        return view('articles.show', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $validatedData = $request->validate([
            'Nome' => 'required|string|max:255',
            'Prix' => 'required|numeric|min:0',
            'prix_gros' => 'nullable|numeric|min:0',
            'prix_achat' => 'nullable|numeric|min:0',
            'prix_importation' => 'nullable|numeric|min:0',
            'Referance' => 'nullable',
            'categorie_id' => 'nullable',
            'barcode' => 'nullable',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($article->image && file_exists(public_path($article->image))) {
                unlink(public_path($article->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('images/articles');

            // Make sure the directory exists
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $image->move($destinationPath, $imageName);
            $validatedData['image'] = 'images/articles/' . $imageName;
        }

        $article->update($validatedData);

        return redirect()->route('articles.index')
            ->with('success', 'Article mis à jour avec succès.');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return response()->json(['success' => true]);
    }

    public function destroyMultiple(Request $request)
    {
        $ids = $request->input('ids');

        if ($ids) {
            Article::whereIn('id', $ids)->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    public function apiSearch(Request $request)
    {
        $term = $request->input('term');
        $page = $request->input('page', 1);
        $excludeOrderId = $request->input('excludeOrderId');
        $perPage = 10;

        $articles = Article::where('barcode', 'LIKE', "%{$term}%")
            ->orWhere('Nome', 'LIKE', "%{$term}%")
            ->paginate($perPage, ['*'], 'page', $page);

        // Transform the articles to include stock information
        $articleData = $articles->items();
        foreach ($articleData as &$article) {
            $article->stock_available = $excludeOrderId ?
                $article->getAvailableStock($excludeOrderId) :
                $article->stock;
        }

        return response()->json([
            'articles' => $articleData,
            'pagination' => [
                'more' => $articles->hasMorePages()
            ]
        ]);
    }

    public function apiStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Nome' => 'required|string|max:255',
            'barcode' => 'nullable|string',
            'Prix' => 'required|numeric|min:0',
            'prix_gros' => 'nullable|numeric|min:0',
            'prix_achat' => 'nullable|numeric|min:0',
            'prix_importation' => 'nullable|numeric|min:0',
            'categorie_id' => 'nullable|exists:categories,id',
            'initial_stock' => 'nullable|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        DB::beginTransaction();

        try {
            // Create the article
            $article = new Article();
            $article->Nome = $request->Nome;
            $article->barcode = $request->barcode;
            $article->Prix = $request->Prix;
            $article->prix_gros = $request->prix_gros;
            $article->prix_achat = $request->prix_achat;
            $article->prix_importation = $request->prix_importation;
            $article->categorie_id = $request->categorie_id;
            $article->save();


            // Check if initial_stock is provided and greater than 0
            if ($request->has('initial_stock') && $request->initial_stock > 0) {

                // Find or create fournisseur with name "Local Stock"
                $fournisseur = Fournisseur::firstOrCreate(
                    ['Nom' => 'Local Stock']
                );

                // Find the latest "Local Stock" achat or create a new one
                $achat = Achat::where('Referance', 'Local Stock')
                    ->where('fournisseur_id', $fournisseur->id)
                    ->latest()
                    ->first();

                if (!$achat) {
                    $achat = Achat::create([
                        'date' => now()->format('Y-m-d'),
                        'Referance' => 'Local Stock',
                        'total' => 0,
                        'subtotal' => 0,
                        'tax_rate' => 0,
                        'tax_amount' => 0,
                        'paye' => 0,
                        'fournisseur_id' => $fournisseur->id,
                    ]);
                }

                // Calculate price for this article
                $articlePrice = $article->prix_importation ?: $article->prix_achat ?: $article->Prix;
                $additionalTotal = floatval($articlePrice) * floatval($request->initial_stock);

                // Update the achat totals
                $achat->total += $additionalTotal;
                $achat->subtotal += $additionalTotal;
                $achat->paye += $additionalTotal;
                $achat->save();

                // Create an achatArticle record to represent initial stock
                $achatArticle = new AchatArticle();
                $achatArticle->achat_id = $achat->id;
                $achatArticle->article_id = $article->id;
                $achatArticle->Quantite = $request->initial_stock;
                $achatArticle->prix = $articlePrice;
                $achatArticle->prix_achat = $article->prix_achat ?: 0;
                $achatArticle->prix_gros = $article->prix_gros ?: 0;
                $achatArticle->prix_importation = $article->prix_importation ?: 0;
                $achatArticle->save();
            }


            DB::commit();

            return response()->json([
                'success' => true,
                'product' => [
                    'id' => $article->id,
                    'Nome' => $article->Nome,
                    'barcode' => $article->barcode,
                    'Prix' => $article->Prix,
                    'prix_gros' => $article->prix_gros,
                    'prix_achat' => $article->prix_achat,
                    'prix_importation' => $article->prix_importation,
                    'categorie_id' => $article->categorie_id,
                    'stock' => $request->initial_stock ?: 0
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
}
