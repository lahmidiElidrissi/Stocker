<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AchatArticle extends Model
{
    use HasFactory;

    protected $fillable = [
        'achat_id',
        'article_id',
        'Quantite',
        'prix'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'achat_articles';

    /**
     * Get the achat that owns this line item.
     */
    public function achat()
    {
        return $this->belongsTo(Achat::class);
    }

    /**
     * Get the article associated with this line item.
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}