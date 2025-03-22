<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\fournisseur;

class FournisseurController extends Controller
{
    function index() {}
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

    function SelectionDelete(Request $request)
    {
        $Selections = $request->Selections;
        foreach ($Selections as $SelectionCurrent) {
            $SelectionCurrent =  fournisseur::find($SelectionCurrent);
            $SelectionCurrent->delete();
        }
        return 1;
    }

    // Add this to your API controller

    /**
     * Store a new supplier in the database via AJAX.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeFournisseur(Request $request)
    {
        try {
            $request->validate([
                'Nom' => 'required|string|max:255',
                'email' => 'nullable|email|max:255',
                'telephone' => 'nullable|string|max:20',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $fournisseur = new Fournisseur();
            $fournisseur->Nom = $request->Nom;
            $fournisseur->email = $request->email;
            $fournisseur->telephone = $request->telephone;

            // Handle image upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('fournisseurs', 'public');
                $fournisseur->image = $imagePath;
            }

            $fournisseur->save();

            return response()->json([
                'success' => true,
                'message' => 'Fournisseur créé avec succès',
                'fournisseur' => $fournisseur
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ], 500);
        }
    }
}
