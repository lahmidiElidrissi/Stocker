<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AricleCommande extends Model
{
    use HasFactory;

    public function commande()
    {
        return $this->belongsTo(commande::class);  
    }

    public function article()
    {
        return $this->belongsTo(article::class);  
    }
    
}
