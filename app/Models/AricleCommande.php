<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AricleCommande extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'aricle_commandes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'commande_id',
        'article_id',
        'Quantite',
        'CustomPrix'
    ];

    /**
     * Get the article that belongs to this relation.
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Get the commande that owns this relation.
     */
    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }
}