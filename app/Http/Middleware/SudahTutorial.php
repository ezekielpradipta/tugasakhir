<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Tutorial;
use Illuminate\Support\Facades\DB;
use UxWeb\SweetAlert\SweetAlert;
class SudahTutorial
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
        $mahasiswa = Auth::user()->mahasiswa->id;
        $mhs = Mahasiswa::find($mahasiswa);
        $tutorial_status = $mhs->mahasiswa_tutorial_status;
        if($mhs->mahasiswa_tutorial_status =="1"){
            
            alert()->warning('Anda Sudah Mengikuti Tutorial', 'Opss');
            return redirect()->route('mahasiswa.index');
        }
        return $next($request);
    }
}
