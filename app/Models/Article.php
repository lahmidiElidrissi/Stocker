<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Nome',
        'Prix',
        'prix_gros',
        'prix_achat',
        'prix_importation',
        'Referance',
        'barcode',
        'categorie_id',
        'image'
    ];

    /**
     * Get the category that owns the article.
     */
    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }

    /**
     * Get the full image path
     */
    public function getImagePathAttribute()
    {
        if ($this->image && !str_starts_with($this->image, 'http')) {
            return asset($this->image);
        }

        return $this->image ?? asset('images/no-image.png');
    }

    // Make sure relationships are defined
    public function achatArticles()
    {
        return $this->hasMany(AchatArticle::class);
    }

    public function aricleCommandes()
    {
        return $this->hasMany(AricleCommande::class);
    }

    /**
     * Calculate the current stock based on purchases and sales
     *
     * @return int
     */
    public function getStockAttribute()
    {
        // Sum of all purchases
        $totalPurchased = $this->achatArticles()
            ->sum('Quantite');

        // Sum of all sales
        $totalSold = $this->aricleCommandes()
            ->sum('Quantite');

        // Available stock = purchases - sales
        return $totalPurchased - $totalSold;
    }


    /**
     * Calculate available stock excluding the specified order's quantity
     *
     * @param int|null $excludeOrderId
     * @return int
     */
    public function getAvailableStock($excludeOrderId = null)
    {
        // Sum of all purchases
        $totalPurchased = $this->achatArticles()->sum('Quantite');

        // Query to sum all sales, optionally excluding a specific order
        $query = $this->aricleCommandes(); // Fixed typo in method name

        if ($excludeOrderId) {
            $query->whereHas('commande', function ($q) use ($excludeOrderId) {
                return $q->where('id', '!=', $excludeOrderId);
            });
        }

        $totalSold = $query->sum('Quantite');

        // Available stock = purchases - sales
        return $totalPurchased - $totalSold;
    }
}
