<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cheque extends Model
{
    use HasFactory;


    public function client()
    {
        return $this->belongsTo(client::class);
    }
}
