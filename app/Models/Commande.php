<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class commande extends Model
{
    use HasFactory;

    public function client()
    {
        return $this->belongsTo(client::class);  
    }
    
    public function user()
    {
        return $this->belongsTo(user::class);  
    }

    public function ArticleCommande()
    {
        return $this->hasMany(ArticleCommande::class);  
    }
}
