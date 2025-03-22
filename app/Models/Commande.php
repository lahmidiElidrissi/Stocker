<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'reference',
        'client_id',
        'subtotal',
        'tax_rate',
        'tax_amount',
        'total',
        'paye',
        'du',
        'notes'
    ];

    /**
     * Get the client that owns the commande.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the commande articles for the commande.
     */
    public function articles()
    {
        return $this->hasMany(AricleCommande::class);
    }

    /**
     * Get all the articles associated with the commande directly.
     */
    public function articlesItems()
    {
        return $this->belongsToMany(Article::class, 'aricle_commandes', 'commande_id', 'article_id')
                    ->withPivot('CustomPrix', 'Quantite');
    }
}