<?php

namespace App\Http\Controllers;
use App\Models\AricleCommande;
use App\Models\commande;
use App\Models\article;
use App\Models\client;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class CommandeController extends Controller
{
    function addCommande(Request $request)
    {
        $request->validate([
            'laDate' => 'required|Date',
            'Client' => 'required|numeric',
            'totel' => 'required|numeric',
            'du' => 'nullable|numeric',
            'paye' => 'nullable|numeric',
            'CustomPrix' =>'required',
        ]);
        $Commande = new Commande;
        $Commande->dateCommnde = $request->laDate;
        $Commande->client_id = $request->Client;
        $Commande->total = $request->totel;
        $Commande->paye  = $request->paye;
        $Commande->du  = $request->du;
        $quantites = $request->quantite;
        $articles = $request->Article;
        $CustomPrix = $request->CustomPrix;
        $Commande->save();
        $idDeCurrentCommande = $Commande->id;
        for ($i=0; $i < count($quantites); $i++) {
            $CommandeArticle =  new AricleCommande;
            $CommandeArticle->Commande_id = $idDeCurrentCommande;
            $CommandeArticle->article_id = $articles[$i];
            $CommandeArticle->Quantite = $quantites[$i];
            $CommandeArticle->CustomPrix = $CustomPrix[$i];
            $CommandeArticle->save();
        }
        return redirect(route('viewGestionDCommandes'));
    }
    
    function UpdateCommande(Request $request)
    {
        $request->validate([
            'laDate' => 'required|Date',
            'Client' => 'required|numeric',
            'totel' => 'required|numeric',
            'du' => 'nullable|numeric',
            'paye' => 'nullable|numeric',
            'CustomPrix' =>'required',
        ]);
         $Commande = Commande::find($request->idDeCommande);
         $Commande->dateCommnde = $request->laDate;
         $Commande->client_id = $request->Client;
         $Commande->total = $request->totel;
         $Commande->paye  = $request->paye;
         $Commande->du  = $request->du;
         $Commande->save();
         $IdDeCurrentCommande = $Commande->id;
         $CommandeArticleCurrent = DB::table('aricle_commandes')
        ->where('Commande_id', '=', $IdDeCurrentCommande)
        ->get();
        foreach ($CommandeArticleCurrent as $CommandeCurrent) {
         $CommandeForDel =  AricleCommande::find($CommandeCurrent->id);
         $CommandeForDel->delete();
        }
        $quantites = $request->quantitesModifier;
        $articles = $request->ArticleModifier;
        $CustomPrix = $request->CustomPrix;
        for ($i=0; $i < count($quantites); $i++) {
            $CommandeArticle =  new AricleCommande;
            $CommandeArticle->Commande_id = $IdDeCurrentCommande;
            $CommandeArticle->article_id = $articles[$i];
            $CommandeArticle->Quantite = $quantites[$i];
            $CommandeArticle->CustomPrix = $CustomPrix[$i];
            $CommandeArticle->save();
        }
        return redirect(route('viewGestionDCommandes'));
    }
    
    function deleteCommande(Request $request)
    {
         $Commande = Commande::findOrFail($request->id);
         $Commande->delete();
         return 1;
    }
    
    function GetInfo(Request $request)
    {
         $Commande = Commande::find($request->id);
         return $Commande;
    }
    
    function GetCommandes()
    {
         $Commandes = Commande::all();
         $Articles = article::all();
         $Clients = client::all();
         return view('GestionDesCommandes')->with('Commandes', $Commandes)->with('Articles', $Articles)->with('Clients', $Clients);
    }
    function ArticlesDeCommande(Request $request)
    {
        $idCommandeArticle = $request->id;
        $CommandeArticle = DB::table('aricle_commandes')
        ->where('commande_id', '=', $idCommandeArticle)
        ->get();
        return $CommandeArticle;
    }

    function SelectionDelete (Request $request)
    {
        $Selections = $request->Selections;
        foreach ($Selections as $SelectionCurrent) {
            $SelectionCurrent =  Commande::find($SelectionCurrent);
            $SelectionCurrent->delete();
           }
        return 1;
    }
    
    function GetTotal(Request $request){
        $nome = $request->selectedText;
        $Prix = article::where('Nome', $nome)->get();
        $Total = (float)$Prix[0]->Prix * (float)$request->qte;
        return $Total;
    }
    
    public function GetPDF(Request $request)
    {
        $Commande = Commande::find($request->id); 
        $CommandeArticle = DB::table('aricle_commandes')
        ->where('commande_id', '=', $request->id)
        ->get();
        $counter = 0;
        foreach($CommandeArticle as $CommandeArticleSingle){
            $idArticle = $CommandeArticleSingle->article_id;
            $articleTemp = article::find($idArticle);
            $CommandeArticle[$counter]->article_id = $articleTemp->Nome;
            $CommandeArticle[$counter]->created_at = (float)$CommandeArticle[$counter]->Quantite * (float)$articleTemp->Prix;
            $counter++;
        }
        $CountCommande = count($CommandeArticle);
        $pages = ceil($CountCommande / 19);
        $moveing = 0;
        $client = client::find($Commande->client_id);
        $pdf = FacadePdf::loadView('pdf.temp',compact('Commande','CommandeArticle','client','pages','moveing'));
        return $pdf->stream("Commande.pdf", array("Attachment" => 0));
    }
}
