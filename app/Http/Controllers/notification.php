<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class notification extends Controller
{
   function index()
   {
    $notifications = DB::select('SELECT * from cheques WHERE DateCheque <= CURDATE() and status = "En cours" or status = "Retour" or status = "Return" or status = "In progress" LIMIT 4;');
    return $notifications;
   }
}
