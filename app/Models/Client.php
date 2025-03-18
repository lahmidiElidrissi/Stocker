<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class client extends Model
{
    use HasFactory;

    public function commande()
    {
        return $this->hasMany(commande::class);
    }

    public function cheque()
    {
        return $this->hasMany(cheque::class);
    }

    public function contenir()
    {
        return $this->belongsTo(Contenir::class);
    }

    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }
}
