<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class ValidasiController extends Controller
{
    public function index()
    {
        return view('mahasiswa.validasi');
    }

    public function dataAjax(Request $request)

    {
        $mahasiswa_id = Auth::user()->mahasiswa->id;
    	
        $data  = $notif= DB::table('notif_tak_masuks')
        ->join('mahasiswas','mahasiswas.id','=','notif_tak_masuks.mahasiswa_id')
        ->join('inputtaks','inputtaks.id','=','notif_tak_masuks.inputtak_id')
        ->join('taks', 'inputtaks.tak_id', '=', 'taks.id') 
        ->join('kegiatantaks', 'taks.kegiatantak_id', '=', 'kegiatantaks.id')
        ->join('partisipasitaks','partisipasitaks.id','=','taks.partisipasitak_id') 
        ->select('notif_tak_masuks.id','kegiatantaks.kegiatantak_nama','partisipasitaks.partisipasitak_nama','taks.tak_score')
        ->where('mahasiswas.id',$mahasiswa_id)
        ->where('notif_tak_masuks.notif_tak_read','1')
        ->orderBy('taks.tak_score','desc')
        ->get();
        
        return response()->json(['data'=>$data]);

    }

}
