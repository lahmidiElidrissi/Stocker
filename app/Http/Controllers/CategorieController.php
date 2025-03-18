<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\categorie;
class CategorieController extends Controller
{
    function GetCategories()
    {
        $Categories = categorie::all();
        return view('GestionDesCategories')->with('categories', $Categories);
    }
    function addCategorie(Request $request)
    {
        $request->validate([
            'nameCategorie' => 'required|string|max:35',
        ]);

        $NomDeClient = $request->nameCategorie;
        $categorie = new categorie;
        $categorie->NomeCategorie = $NomDeClient;
        $categorie->save();
        return redirect()->route('viewGestionDesCategories');
    }

    function GetInfo(Request $request)
    {
        $categories = categorie::findOrFail($request->id);
        return $categories;
    }
    function UpdateCategorie(Request $request)
    {
        $categorie = categorie::FindOrFail($request->idDeCategorie);
        $categorie->NomeCategorie = $request->nameCategorie;
        $categorie->save();
        return redirect()->route('viewGestionDesCategories');
        //return $request;
    }
    function deleteCategorie(Request $request)
    {
        $Idcategorie = $request->id;
        $categorie = categorie::findOrFail($Idcategorie);
        $categorie->delete();
        return 1;
    }

    function SelectionDelete (Request $request)
    {
        $Selections = $request->Selections;
        foreach ($Selections as $SelectionCurrent) {
            $SelectionCurrent =  categorie::find($SelectionCurrent);
            $SelectionCurrent->delete();
           }
        return 1;
    }
}
