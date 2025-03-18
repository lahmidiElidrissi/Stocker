<?php

namespace App\Http\Controllers;
use App\Models\contenir;
use App\Models\fournisseur;
use App\Models\pay;
use Illuminate\Http\Request;

class ContenirController extends Controller
{
    function addContenir(Request $request)
    {
        $request->validate([
            'referance' => 'required|string|max:25',
            'pays' => 'required|string|max:50',
            'dateDeEntree' => 'required|date',
        ]);

        $contenir = new contenir;
        $contenir->Referance = $request->referance;
        $contenir->PayeOrigine = $request->pays;
        $contenir->DateEntree = $request->dateDeEntree;
        $contenir->fournisseur_id  = $request->fournisseur;
        $contenir->save();
        return redirect(route('viewGestionDesContenirs'));
    }

    function UpdateContenir(Request $request)
    {
        $request->validate([
            'referance' => 'required|string|max:25',
            'pays' => 'required|string|max:50',
            'dateDeEntree' => 'required|date',
        ]);

        $contenir = contenir::find($request->idDeContenir);
        $contenir->Referance = $request->referance;
        $contenir->PayeOrigine = $request->pays;
        $contenir->DateEntree = $request->dateDeEntree;
        $contenir->fournisseur_id = $request->fournisseur ;
        $contenir->save();
        return redirect(route('viewGestionDesContenirs'));
    }
    function deleteContenir(Request $request)
    {
        $contenir = contenir::findOrFail($request->id);
        $contenir->delete();
        return 1;
    }
    function GetInfo(Request $request)
    {
        $contenir = contenir::find($request->id);
        return $contenir;
    }
    function GetContenirs()
    {
        $contenirs = Contenir::all();
        $pays = pay::all();
        $fournisseurs = fournisseur::all();
        return view('GestionDesContenirs')->with('contenirs', $contenirs)->with('pays', $pays)->with('fournisseurs', $fournisseurs);
    }

    function SelectionDelete (Request $request)
    {
        $Selections = $request->Selections;
        foreach ($Selections as $SelectionCurrent) {
            $SelectionCurrent =  Contenir::find($SelectionCurrent);
            $SelectionCurrent->delete();
           }
        return 1;
    }
}
