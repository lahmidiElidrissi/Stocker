<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class getLocal extends Controller
{
   static function GetLocal()
    {
        return App::getLocale();
    }

    function ChangeLan(Request $request)
    {
        $id = Auth::id();
        $user = User::find($id);
        $user->Locale = $request->lang;
        $user->save();
        return 1;
    }
}
