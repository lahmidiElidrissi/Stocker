<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class LesRapportController extends Controller
{
    function index()
    {
       $TopProductForSale = DB::select('SELECT articles.Nome,sum(Quantite) as Total_Quantite,sum(Quantite)*articles.Prix AS Total_Prix
       FROM aricle_commandes,articles where aricle_commandes.article_id = articles.id GROUP BY aricle_commandes.article_id ORDER by Total_Prix DESC LIMIT 8;');
       return view("ProduitPlusVente")->with('TopProductForSale',$TopProductForSale);
    }
    function DashbordRapports()
    {
        $en = Carbon::now()->locale('en_US');
        $char1 = '"';
        $startOfweek = $en->startOfWeek();
        //ce semaine data
        $Sunday   = $startOfweek->copy()->subDays(0)->format('Y-m-d');
        $Monday   = $startOfweek->copy()->subDays(-1)->format('Y-m-d');
        $Tuesday  = $startOfweek->copy()->subDays(-2)->format('Y-m-d');
        $Wednesday= $startOfweek->copy()->subDays(-3)->format('Y-m-d');
        $Thursday = $startOfweek->copy()->subDays(-4)->format('Y-m-d');
        $Friday   = $startOfweek->copy()->subDays(-5)->format('Y-m-d');
        $Saturday = $startOfweek->copy()->subDays(-6)->format('Y-m-d');

        //Dernière Semaine data
        $LastSunday    = $startOfweek->copy()->subDays(7)->format('Y-m-d');
        $LastMonday    = $startOfweek->copy()->subDays(6)->format('Y-m-d');
        $LastTuesday   = $startOfweek->copy()->subDays(5)->format('Y-m-d');
        $LastWednesday = $startOfweek->copy()->subDays(4)->format('Y-m-d');
        $LastThursday  = $startOfweek->copy()->subDays(3)->format('Y-m-d');
        $LastFriday    = $startOfweek->copy()->subDays(2)->format('Y-m-d');
        $LastSaturday  = $startOfweek->copy()->subDays(1)->format('Y-m-d');

        //ce semaine data From DB
         $dataSunday = DB::select('SELECT IFNULL(sum(aricle_commandes.Quantite) , 0) as Total_Quantite FROM aricle_commandes,commandes
         where aricle_commandes.commande_id = commandes.id AND commandes.date = '.$char1.$Sunday.$char1.'; ');
         $dataMonday = DB::select('SELECT IFNULL(sum(aricle_commandes.Quantite) , 0) as Total_Quantite FROM aricle_commandes,commandes
         where aricle_commandes.commande_id = commandes.id AND commandes.date = '.$char1.$Monday.$char1.'; ');
         $datatTuesday = DB::select('SELECT IFNULL(sum(aricle_commandes.Quantite) , 0) as Total_Quantite FROM aricle_commandes,commandes
         where aricle_commandes.commande_id = commandes.id AND commandes.date = '.$char1.$Tuesday.$char1.'; ');
         $dataWednesday = DB::select('SELECT IFNULL(sum(aricle_commandes.Quantite) , 0) as Total_Quantite FROM aricle_commandes,commandes
         where aricle_commandes.commande_id = commandes.id AND commandes.date = '.$char1.$Wednesday.$char1.'; ');
         $dataThursday = DB::select('SELECT IFNULL(sum(aricle_commandes.Quantite) , 0) as Total_Quantite FROM aricle_commandes,commandes
         where aricle_commandes.commande_id = commandes.id AND commandes.date = '.$char1.$Thursday.$char1.'; ');
         $dataFriday = DB::select('SELECT IFNULL(sum(aricle_commandes.Quantite) , 0) as Total_Quantite FROM aricle_commandes,commandes
         where aricle_commandes.commande_id = commandes.id AND commandes.date = '.$char1.$Friday.$char1.'; ');
         $dataSaturday = DB::select('SELECT IFNULL(sum(aricle_commandes.Quantite) , 0) as Total_Quantite FROM aricle_commandes,commandes
         where aricle_commandes.commande_id = commandes.id AND commandes.date = '.$char1.$Saturday.$char1.'; ');

         //Dernière semaine data From DB
         $dataLastMonday = DB::select('SELECT IFNULL(sum(aricle_commandes.Quantite) , 0) as Total_Quantite FROM aricle_commandes,commandes
         where aricle_commandes.commande_id = commandes.id AND commandes.date = '.$char1.$LastMonday.$char1.'; ');
         $dataLastTuesday = DB::select('SELECT IFNULL(sum(aricle_commandes.Quantite) , 0) as Total_Quantite FROM aricle_commandes,commandes
         where aricle_commandes.commande_id = commandes.id AND commandes.date = '.$char1.$LastTuesday.$char1.'; ');
         $dataLastWednesday = DB::select('SELECT IFNULL(sum(aricle_commandes.Quantite) , 0) as Total_Quantite FROM aricle_commandes,commandes
         where aricle_commandes.commande_id = commandes.id AND commandes.date = '.$char1.$LastWednesday.$char1.'; ');
         $dataLastThursday = DB::select('SELECT IFNULL(sum(aricle_commandes.Quantite) , 0) as Total_Quantite FROM aricle_commandes,commandes
         where aricle_commandes.commande_id = commandes.id AND commandes.date = '.$char1.$LastThursday.$char1.'; ');
         $dataLastFriday = DB::select('SELECT IFNULL(sum(aricle_commandes.Quantite) , 0) as Total_Quantite FROM aricle_commandes,commandes
         where aricle_commandes.commande_id = commandes.id AND commandes.date = '.$char1.$LastFriday.$char1.'; ');
         $dataLastSaturday = DB::select('SELECT IFNULL(sum(aricle_commandes.Quantite) , 0) as Total_Quantite FROM aricle_commandes,commandes
         where aricle_commandes.commande_id = commandes.id AND commandes.date = '.$char1.$LastSaturday.$char1.'; ');
         $dataLastSunday = DB::select('SELECT IFNULL(sum(aricle_commandes.Quantite) , 0) as Total_Quantite FROM aricle_commandes,commandes
         where aricle_commandes.commande_id = commandes.id AND commandes.date = '.$char1.$LastSunday.$char1.'; ');


        //Data De Ce Semaine
        $dataForWeek = array($dataSunday,$dataMonday,$datatTuesday,$dataWednesday,$dataThursday,$dataFriday,$dataSaturday,$dataLastSunday,$dataLastMonday,$dataLastTuesday,$dataLastWednesday,$dataLastThursday,$dataLastFriday,$dataLastSaturday);
        return $dataForWeek;
    }

    function RapportDeVente(){
        return view('RapportDeVente');
    }

    function TopClient()
    {
        $TopClient = DB::select('SELECT getnameclient(client_id) as name ,  sum(total) as totalprix ,max(date) as dates FROM `commandes` GROUP by client_id order by totalprix DESC;');
        return view('clientRapport')->with('TopClient',$TopClient);;
    }
    function DashbordRapportsStock()
    {
    $Global_stock = DB::select('SELECT sum(Quantite) as GlobalStock FROM `achat_articles`');
    $Produits_vente = DB::select('SELECT sum(Quantite) as ProduitsVente FROM `aricle_commandes`');
    $Produits_en_stock = (int) $Global_stock[0]->GlobalStock - (int) $Produits_vente[0]->ProduitsVente;
    $returs = array($Global_stock,$Produits_vente,$Produits_en_stock);
    return $returs;
    }

    function DashbordRapports2()
    {
        $en = Carbon::now()->locale('en_US');
        $char1 = '"';
        $startOfweek = $en->startOfWeek();
        //ce semaine data
        $Sunday   = $startOfweek->copy()->subDays(0)->format('Y-m-d');
        $Monday   = $startOfweek->copy()->subDays(-1)->format('Y-m-d');
        $Tuesday  = $startOfweek->copy()->subDays(-2)->format('Y-m-d');
        $Wednesday= $startOfweek->copy()->subDays(-3)->format('Y-m-d');
        $Thursday = $startOfweek->copy()->subDays(-4)->format('Y-m-d');
        $Friday   = $startOfweek->copy()->subDays(-5)->format('Y-m-d');
        $Saturday = $startOfweek->copy()->subDays(-6)->format('Y-m-d');

        //Dernière Semaine data
        $LastSunday    = $startOfweek->copy()->subDays(7)->format('Y-m-d');
        $LastMonday    = $startOfweek->copy()->subDays(6)->format('Y-m-d');
        $LastTuesday   = $startOfweek->copy()->subDays(5)->format('Y-m-d');
        $LastWednesday = $startOfweek->copy()->subDays(4)->format('Y-m-d');
        $LastThursday  = $startOfweek->copy()->subDays(3)->format('Y-m-d');
        $LastFriday    = $startOfweek->copy()->subDays(2)->format('Y-m-d');
        $LastSaturday  = $startOfweek->copy()->subDays(1)->format('Y-m-d');

        //ce semaine data From DB
        $dataSunday = DB::select('SELECT IFNULL(max(commandes.total) , 0) as Total_Quantite FROM aricle_commandes,commandes,articles
        where aricle_commandes.commande_id = commandes.id AND aricle_commandes.article_id = articles.id AND commandes.date = '.$char1.$Sunday.$char1.'; ');
        
        $dataMonday = DB::select('SELECT IFNULL(max(commandes.total) , 0) as Total_Quantite FROM aricle_commandes,commandes,articles
        where aricle_commandes.commande_id = commandes.id AND aricle_commandes.article_id = articles.id AND commandes.date = '.$char1.$Monday.$char1.'; ');
        $datatTuesday = DB::select('SELECT IFNULL(max(commandes.total) , 0) as Total_Quantite FROM aricle_commandes,commandes,articles
        where aricle_commandes.commande_id = commandes.id AND aricle_commandes.article_id = articles.id AND commandes.date = '.$char1.$Tuesday.$char1.'; ');
        $dataWednesday = DB::select('SELECT IFNULL(max(commandes.total) , 0) as Total_Quantite FROM aricle_commandes,commandes,articles
        where aricle_commandes.commande_id = commandes.id AND aricle_commandes.article_id = articles.id AND commandes.date = '.$char1.$Wednesday.$char1.'; ');
        $dataThursday = DB::select('SELECT IFNULL(max(commandes.total) , 0) as Total_Quantite FROM aricle_commandes,commandes,articles
        where aricle_commandes.commande_id = commandes.id AND aricle_commandes.article_id = articles.id AND commandes.date = '.$char1.$Thursday.$char1.'; ');
        $dataFriday = DB::select('SELECT IFNULL(max(commandes.total) , 0) as Total_Quantite FROM aricle_commandes,commandes,articles
        where aricle_commandes.commande_id = commandes.id AND aricle_commandes.article_id = articles.id AND commandes.date = '.$char1.$Friday.$char1.'; ');
        $dataSaturday = DB::select('SELECT IFNULL(max(commandes.total) , 0) as Total_Quantite FROM aricle_commandes,commandes,articles
        where aricle_commandes.commande_id = commandes.id AND aricle_commandes.article_id = articles.id AND commandes.date = '.$char1.$Saturday.$char1.'; ');

        //Dernière semaine data From DB
        $dataLastMonday = DB::select('SELECT IFNULL(max(commandes.total) , 0) as Total_Quantite FROM aricle_commandes,commandes,articles
        where aricle_commandes.commande_id = commandes.id AND aricle_commandes.article_id = articles.id AND commandes.date = '.$char1.$LastMonday.$char1.'; ');
        $dataLastTuesday = DB::select('SELECT IFNULL(max(commandes.total) , 0) as Total_Quantite FROM aricle_commandes,commandes,articles
        where aricle_commandes.commande_id = commandes.id AND aricle_commandes.article_id = articles.id AND commandes.date = '.$char1.$LastTuesday.$char1.'; ');
        $dataLastWednesday = DB::select('SELECT IFNULL(max(commandes.total) , 0) as Total_Quantite FROM aricle_commandes,commandes,articles
        where aricle_commandes.commande_id = commandes.id AND aricle_commandes.article_id = articles.id AND commandes.date = '.$char1.$LastWednesday.$char1.'; ');
        $dataLastThursday = DB::select('SELECT IFNULL(max(commandes.total) , 0) as Total_Quantite FROM aricle_commandes,commandes,articles
        where aricle_commandes.commande_id = commandes.id AND aricle_commandes.article_id = articles.id AND commandes.date = '.$char1.$LastThursday.$char1.'; ');
        $dataLastFriday = DB::select('SELECT IFNULL(max(commandes.total) , 0) as Total_Quantite FROM aricle_commandes,commandes,articles
        where aricle_commandes.commande_id = commandes.id AND aricle_commandes.article_id = articles.id AND commandes.date = '.$char1.$LastFriday.$char1.'; ');
        $dataLastSaturday = DB::select('SELECT IFNULL(max(commandes.total) , 0) as Total_Quantite FROM aricle_commandes,commandes,articles
        where aricle_commandes.commande_id = commandes.id AND aricle_commandes.article_id = articles.id AND commandes.date = '.$char1.$LastSaturday.$char1.'; ');
        $dataLastSunday = DB::select('SELECT IFNULL(max(commandes.total) , 0) as Total_Quantite FROM aricle_commandes,commandes,articles
        where aricle_commandes.commande_id = commandes.id AND aricle_commandes.article_id = articles.id AND commandes.date = '.$char1.$LastSunday.$char1.'; ');


        //Data De Ce Semaine
        $dataForWeek = array($dataLastSunday,$dataLastMonday,$dataLastTuesday,$dataLastWednesday,$dataLastThursday,$dataLastFriday,$dataLastSaturday,$dataSunday,$dataMonday,$datatTuesday,$dataWednesday,$dataThursday,$dataFriday,$dataSaturday);
        return $dataForWeek;
    }

}
