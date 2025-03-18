<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class lan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

       $lang = null;
       $id = null;
       try {
       $id = Auth::id();
        } catch (\Throwable $th) {}
       try {
        $locate = DB::select("select Locale from users where id = ".$id.";");
       } catch (\Throwable $th) {}
       try {
       $lang = $locate[0]->Locale;
       } catch (\Throwable $th) {}

       if ($lang != null && $id != null) {

        App::setLocale($locate[0]->Locale);

       }else{
        $localLang = Storage::disk('public')->get('lang.json');
        App::setLocale(json_decode($localLang));
       }
       
       return $next($request);
    }
}
