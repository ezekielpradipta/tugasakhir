<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Takkumulatif;
class ValidasiMahasiswa
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
        $angkatan = $mahasiswa->angkatan_id;
        $prodi = $mahasiswa->prodi_id;
        $tak = Takkumulatif::where('angkatan_id',$angkatan)->where('prodi',$prodi)->first();
        return $next($request);
    }
}
