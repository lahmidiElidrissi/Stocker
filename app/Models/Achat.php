<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achat extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'Referance',
        'fournisseur_id',
        'contenir_id',
        'subtotal',
        'tax_rate',
        'tax_amount',
        'total',
        'paye',
        'du'
    ];

    /**
     * Get the supplier that owns the purchase.
     */
    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }

    /**
     * Get the container that owns the purchase.
     */
    public function contenir()
    {
        return $this->belongsTo(Contenir::class);
    }

    /**
     * Get the articles for the purchase.
     * This relationship connects to the pivot/join table.
     */
    public function articles()
    {
        return $this->hasMany(AchatArticle::class, 'achat_id');
    }

    /**
     * Get all the articles associated with the purchase directly.
     * This is a convenience method that goes through the pivot/join table.
     */
    public function articlesItems()
    {
        return $this->belongsToMany(Article::class, 'achat_articles', 'achat_id', 'article_id')
                    ->withPivot('Quantite', 'CustomPrix');
    }
}