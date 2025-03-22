<?php

namespace App\Http\Controllers;
use App\Models\commande;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class welcome extends Controller
{
    function index()
    {
        $en = Carbon::now()->locale('en_US')->format('Y-m-d');
        $en2 = Carbon::now()->locale('en_US')->format('Y-m') ."-01";
        $char1 = '"';
        $data = DB::select('SELECT IFNULL(sum(aricle_commandes.Quantite) , 0) as Total_Quantite FROM aricle_commandes,commandes
         where aricle_commandes.commande_id = commandes.id AND commandes.date BETWEEN '.$char1.$en2.$char1.' AND '.$char1.$en.$char1.' ; ');

        $commandes = DB::select('SELECT getinfo(commandes.du,commandes.total) as pourcentage,getClasseName(getinfo(commandes.du,commandes.total)) as className, clients.Nom as client_nom , clients.image , commandes.date as commande_date , commandes.total , commandes.paye , commandes.du FROM commandes , clients WHERE commandes.client_id = clients.id ORDER by commande_date DESC LIMIT 6; ');
        
        return view("welcome")->with('commandes',$commandes)->with('data',$data);
        

    }
}
