<?php

namespace App\Http\Controllers;

use App\Models\cheque;
use App\Models\client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChequeController extends Controller
{
    function GetCheques()
    {
        $Cheques = DB::select("SELECT cheques.id , cheques.codeCheqe , cheques.DateCheque , cheques.status , clients.Nom FROM cheques , clients WHERE cheques.Client_id = clients.id; ");
        $Clients = client::all();
        return view('GestionDesCheque')->with("Cheques" , $Cheques)->with("Clients",$Clients);
    }

    function addCheque (Request $request)
    {
        $request->validate([
            'Client' => 'required|integer',
            'codeCheqe' => 'required|string|unique:cheques',
            'dateCheque' => 'required|string',
            'status' => 'required|string',
        ]);
        $cheque = new cheque();
        $cheque->Client_id = $request->Client;
        $cheque->codeCheqe = $request->codeCheqe;
        $cheque->DateCheque = $request->dateCheque;
        $cheque->status = $request->status;
        $cheque->save();
        return redirect(route('viewGestiondesCheqes'));
    }

    function UpdateCheque(Request $request)
    {
        $request->validate([
            'Client' => 'required|string',
            'codeCheqe' => 'required|string',
            'dateCheque' => 'required|string',
            'status' => 'required|string',
        ]);
        $cheque = cheque::FindOrFail($request->idDecheque);
        $cheque->Client_id = $request->Client;
        $cheque->codeCheqe = $request->codeCheqe;
        $cheque->DateCheque = $request->dateCheque;
        $cheque->status = $request->status;
        $cheque->save();
        return redirect()->route('viewGestiondesCheqes');
    }

    function GetInfo(Request $request)
    {
        $cheque = cheque::findOrFail($request->id);
        return $cheque;
    }

    function deleteCheque(Request $request)
    {
        $IdUser = $request->id;
        $User = cheque::findOrFail($IdUser);
        $User->delete();
        return 1;
    }

    function SelectionDelete (Request $request)
    {
        $Selections = $request->Selections;
        foreach ($Selections as $SelectionCurrent) {
            $SelectionCurrent =  cheque::find($SelectionCurrent);
            $SelectionCurrent->delete();
           }
        return 1;
    }
}
