<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function GetUsers()
    {
        $Users = User::all();
        return view('GestiondesUtilisateurs')->with("Users" , $Users);
    }

    function addUser (Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect(route('viewGestiondesUtilisateurs'));
    }

    function UpdateUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        $user = User::FindOrFail($request->idDeUser);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make( $request->password);
        $user->save();
        return redirect()->route('viewGestiondesUtilisateurs');
    }

    function GetInfo(Request $request)
    {
        $Users = User::findOrFail($request->id);
        return $Users;
    }

    function deleteUser(Request $request)
    {
        $IdUser = $request->id;
        $User = User::findOrFail($IdUser);
        $User->delete();
        return 1;
    }

    function SelectionDelete (Request $request)
    {
        $Selections = $request->Selections;
        foreach ($Selections as $SelectionCurrent) {
            $SelectionCurrent =  User::find($SelectionCurrent);
            $SelectionCurrent->delete();
           }
        return 1;
    }
}


