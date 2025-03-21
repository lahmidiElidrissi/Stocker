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
     * Get the purchase items for the article.
     */
    public function achatArticles()
    {
        return $this->hasMany(AchatArticle::class);
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
}