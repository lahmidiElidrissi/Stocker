<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\client;

class ClientController extends Controller
{
    function GetClients()
    {
        $Clients = client::all();
        return view('GestionDesClients')->with('Clients', $Clients);
    }
    function addClient(Request $request)
    {
        $request->validate([
            'nomDeClient' => 'required|string|max:35',
            'EmailDeClient' => 'nullable|email|max:50',
            'TelephoneDeCLient' => 'nullable|string|max:20',
            'SocieteDeCLient' => 'nullable|max:35',
            'ImageDeCLient' => 'nullable|image',
        ]);

        $NomDeClient = $request->nomDeClient;
        $EmailDeClient = $request->EmailDeClient;
        $TelephoneDeCLient = $request->TelephoneDeCLient;
        $Client = new client;
        $Client->Nom = $NomDeClient;
        $Client->Telephone = $TelephoneDeCLient;
        $Client->Email = $EmailDeClient;
        $Client->Societe = $request->SocieteDeCLient;
        if ($request->file('ImageDeCLient') != null) {
            $file = $request->file('ImageDeCLient');
            $MakePath = '/public/images/e' . date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('/public/images'), $MakePath);
            $Client->image = $MakePath;
        }
        if ($request->file('ImageDeCLient') == null) {
            $MakePath = 'images\aucunimage.jpg';
            $Client->image = $MakePath;
        }
        $Client->save();
        return redirect()->route('viewGestionDesClients');
    }

    function GetInfo(Request $request)
    {
        $CLients = client::findOrFail($request->id);
        return $CLients;
    }
    function UpdateClient(Request $request)
    {
        $request->validate([
            'nomDeClient' => 'required|string|max:35',
            'EmailDeClient' => 'email|max:50',
            'TelephoneDeCLient' => 'string|max:20',
            'SocieteDeCLient' => 'string|max:35',
            'ImageDeCLient' => 'image',
        ]);
        $Client = client::FindOrFail($request->idDeClient);
        $Client->Nom = $request->nomDeClient;
        $Client->Telephone = $request->TelephoneDeCLient;
        $Client->Email = $request->EmailDeClient;
        $Client->Societe = $request->SocieteDeCLient;
        if ($request->file('ImageDeCLient')) {
            $file = $request->file('ImageDeCLient');
            $MakePath = '/public/images/e' . date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('/public/images'), $MakePath);
            $Client->image = $MakePath;
        }
        $Client->save();
        return redirect()->route('viewGestionDesClients');
    }
    function deleteClient(Request $request)
    {
        $IdClient = $request->id;
        $client = client::findOrFail($IdClient);
        $client->delete();
        return 1;
    }

    function SelectionDelete(Request $request)
    {
        $Selections = $request->Selections;
        foreach ($Selections as $SelectionCurrent) {
            $SelectionCurrent =  client::find($SelectionCurrent);
            $SelectionCurrent->delete();
        }
        return 1;
    }

    public function getClientsList()
    {
        $clients = Client::select('id', 'Nom')->get();
        return response()->json($clients);
    }
}
