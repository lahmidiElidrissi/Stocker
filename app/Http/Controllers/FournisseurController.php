<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\fournisseur;

class FournisseurController extends Controller
{
    function index()
    {

    }
    function addFournisseur(Request $request)
    {
        $request->validate([
            'nomeDeFournisseur' => 'required|string|max:25',
            'EmailDeFournisseur' => 'required|email|max:50',
            'TeleDeFournisseur' => 'required|string|max:20',
        ]);

        $NameFournisseur = $request->nomeDeFournisseur;
        $EmailDeFournisseur = $request->EmailDeFournisseur;
        $TeleDeFournisseur = $request->TeleDeFournisseur;

        $fournisseur = new fournisseur;
        $fournisseur->Nom = $NameFournisseur;
        $fournisseur->email = $EmailDeFournisseur;
        $fournisseur->telephone = $TeleDeFournisseur;
        $fournisseur->save();
        return redirect(route('viewGestionDesFournisseurs'));
    }

    function UpdateFournisseur(Request $request)
    {
        $request->validate([
            'nomeDeFournisseur' => 'required|string|max:25',
            'EmailDeFournisseur' => 'required|email|max:50',
            'TeleDeFournisseur' => 'required|string|max:20',
        ]);

        $idFournisseur = $request->idDeFournisseur;
        $NameFournisseur = $request->nomeDeFournisseur;
        $EmailDeFournisseur = $request->EmailDeFournisseur;
        $TeleDeFournisseur = $request->TeleDeFournisseur;

        $fournisseur = fournisseur::findOrFail($idFournisseur);
        $fournisseur->Nom = $NameFournisseur;
        $fournisseur->email = $EmailDeFournisseur;
        $fournisseur->telephone = $TeleDeFournisseur;
        $fournisseur->save();
        return redirect(route('viewGestionDesFournisseurs'));
    }

    function deleteFournisseur(Request $request)
    {
        $idFournisseur = $request->id;
        $fournisseur = fournisseur::findOrFail($idFournisseur);
        $fournisseur->delete();
        return 1;
    }

    function GetFournisseurs()
    {
        $fournisseurs = fournisseur::all();
        return view('GestionDesFournisseurs')->with('fournisseurs', $fournisseurs);
    }

    function GetInfo(Request $request)
    {
        $fournisseurs = fournisseur::findOrFail($request->id);
        return $fournisseurs;
    }

    function SelectionDelete (Request $request)
    {
        $Selections = $request->Selections;
        foreach ($Selections as $SelectionCurrent) {
            $SelectionCurrent =  fournisseur::find($SelectionCurrent);
            $SelectionCurrent->delete();
           }
        return 1;
    }
}
