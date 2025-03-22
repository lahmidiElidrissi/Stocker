<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\AchatArticle;
use App\Models\AricleCommande;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Builder;

class StockController extends Controller
{
    /**
     * Display a listing of current stock.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $articles = Article::with('categorie')
                ->select('articles.*')
                ->withStock();

            if ($request->has('category_id') && $request->category_id) {
                $articles->where('categorie_id', $request->category_id);
            }

            return DataTables::of($articles)
                ->addColumn('checkbox', function ($article) {
                    return '<input type="checkbox" class="dt-checkboxes" value="' . $article->id . '">';
                })
                ->addColumn('image', function ($article) {
                    return $article->image
                        ? '<img src="' . asset($article->image) . '" class="article-thumbnail">'
                        : '<img src="' . asset('images/no-image.png') . '" class="article-thumbnail">';
                })
                ->editColumn('categorie', function ($article) {
                    return $article->categorie->NomeCategorie ?? 'N/A';
                })
                ->editColumn('stock', function ($article) {
                    $stock = $article->stock ?? 0;
                    $class = $stock <= 5 ? 'text-danger' : ($stock <= 10 ? 'text-warning' : 'text-success');
                    return '<span class="' . $class . '">' . $stock . '</span>';
                })
                ->addColumn('action', function ($article) {
                    return '<div class="d-flex align-items-center">
                        <a href="' . route('articles.show', $article->id) . '" class="btn btn-info me-2 buttontr d-flex align-items-center">
                            <i class="mdi mdi-eye mx-auto"></i>
                        </a>
                        <a href="' . route('articles.edit', $article->id) . '" class="btn btn-primary me-2 buttontr d-flex align-items-center">
                            <i class="mdi mdi-pencil mx-auto"></i>
                        </a>
                    </div>';
                })
                ->rawColumns(['checkbox', 'image', 'stock', 'action'])
                ->make(true);
        }

        $categories = Categorie::all();
        return view('stock.index', compact('categories'));
    }

    /**
     * Get stock movement history for a specific article
     */
    public function getArticleHistory($id)
    {
        $article = Article::findOrFail($id);
        
        // Get purchase history
        $purchases = AchatArticle::where('article_id', $id)
            ->with('achat.fournisseur')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => $item->achat->date ?? $item->created_at->format('Y-m-d'),
                    'type' => 'purchase',
                    'reference' => $item->achat->id ?? 'N/A',
                    'quantity' => $item->Quantite,
                    'price' => $item->prix,
                    'source' => $item->achat->fournisseur->Nom ?? 'N/A',
                ];
            });
            
        // Get sales history
        $sales = AricleCommande::where('article_id', $id)
            ->with('commande.client')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => $item->commande->date ?? $item->created_at->format('Y-m-d'),
                    'type' => 'sale',
                    'reference' => $item->commande->id ?? 'N/A',
                    'quantity' => -1 * $item->Quantite, // Negative to indicate outgoing
                    'price' => $item->CustomPrix,
                    'source' => $item->commande->client->Nom ?? 'N/A',
                ];
            });
            
        // Combine and sort by date
        $history = $purchases->concat($sales)->sortByDesc('date')->values();
        
        // Calculate current stock
        $stock = $purchases->sum('quantity') + $sales->sum('quantity');
        
        return view('stock.history', compact('article', 'history', 'stock'));
    }

    /**
     * Generate stock alert report
     */
    public function alerts()
    {
        // You can customize the threshold for low stock alerts
        $lowStockThreshold = 10;
        
        $lowStockArticles = Article::withStock()
            ->having('stock', '<=', $lowStockThreshold)
            ->orderBy('stock')
            ->get();
            
        return view('stock.alerts', compact('lowStockArticles', 'lowStockThreshold'));
    }

    /**
     * Generate stock report
     */
    public function report(Request $request)
    {
        $categorieId = $request->input('categorie_id');
        
        $query = Article::withStock();
        
        if ($categorieId) {
            $query->where('categorie_id', $categorieId);
        }
        
        $articles = $query->orderBy('Nome')->get();
        $categories = Categorie::all();
        
        $totalStock = $articles->sum('stock');
        $totalValue = $articles->sum(function ($article) {
            return $article->stock * $article->prix_achat ?? 0;
        });
        
        return view('stock.report', compact('articles', 'categories', 'categorieId', 'totalStock', 'totalValue'));
    }
}