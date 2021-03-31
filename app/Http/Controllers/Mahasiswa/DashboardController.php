<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NotifTakMasuk;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{
    public function index(){
        $mahasiswa = Auth::user()->mahasiswa->id;
        $score = DB::table('notif_tak_masuks')
        ->join('mahasiswas','mahasiswas.id','=','notif_tak_masuks.mahasiswa_id')
        ->join('inputtaks','inputtaks.id','=','notif_tak_masuks.inputtak_id')
        ->join('taks','taks.id','=','inputtaks.tak_id') 
        ->where('mahasiswas.id',$mahasiswa)
        ->where('notif_tak_masuks.notif_tak_read','1')
        ->sum('taks.tak_score');
        return view('mahasiswa.index',compact('score'));
    }
    public function notif(){
        $mahasiswa = Auth::user()->mahasiswa->id;
        
        //$notif =NotifTakMasuk::with('dosen')->where('mahasiswa_id', '=', $mahasiswa)->get();
        $notif= DB::table('notif_tak_masuks')
            ->join('mahasiswas','mahasiswas.id','=','notif_tak_masuks.mahasiswa_id')
            ->join('dosens','dosens.id','=','notif_tak_masuks.dosen_id')
            ->join('inputtaks','inputtaks.id','=','notif_tak_masuks.inputtak_id')
            ->select('notif_tak_masuks.id','notif_tak_masuks.updated_at','dosens.dosen_nama','dosens.dosen_image')
            ->where('mahasiswas.id',$mahasiswa)
            ->where('notif_tak_masuks.notif_tak_read','0')
            ->get();
        $jumlah = $notif->count();
        $score = DB::table('notif_tak_masuks')
        ->join('mahasiswas','mahasiswas.id','=','notif_tak_masuks.mahasiswa_id')
        ->join('inputtaks','inputtaks.id','=','notif_tak_masuks.inputtak_id')
        ->join('taks','taks.id','=','inputtaks.tak_id') 
        ->where('mahasiswas.id',$mahasiswa)
        ->where('notif_tak_masuks.notif_tak_read','1')
        ->sum('taks.tak_score');
        return response()->json(['notif'=>$notif,'jumlah'=>$jumlah,'score'=>$score]);
    }
    public function DetailNotif($id){
        $notif = NotifTakMasuk::find($id);
        $kegiatantak = $notif->inputtak->tak->kegiatantak->kegiatantak_nama;
        $partisipasitak = $notif->inputtak->tak->partisipasitak->partisipasitak_nama;
        $skor = $notif->inputtak->tak->tak_score;
        return response()->json(['notif'=>$notif,'skor'=>$skor,'partisipasitak'=>$partisipasitak,'kegiatantak'=>$kegiatantak]);
   
    }
    public function ReadNotif($id){
        $notif = NotifTakMasuk::findOrFail($id);
        $notif->notif_tak_read = '1';
        $notif->save();
        return response()->json();
    }

}
