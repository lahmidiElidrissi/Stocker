<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contenir extends Model
{
    use HasFactory;

    public function fournisseur()
    {
        return $this->belongsTo(fournisseur::class);  
    }
    public function achat()
    {
        return $this->hasMany(achat::class);   
    }
}