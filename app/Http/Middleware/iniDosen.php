<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class iniDosen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::user()->status==User::USER_IS_NOT_ACTIVE){
            Auth::logout();
            return redirect()->route('login')->with('fail','Akun anda belum diaktifkan');
        }
        if(Gate::allows('roleDosen')){
            return $next($request);
        } else{
            abort(403,'Anda tidak memiliki Akses untuk halaman ini');
        }
    }
}
