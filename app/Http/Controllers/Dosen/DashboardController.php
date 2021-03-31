<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inputtak;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{
    public function dashboard(){
        
        return view('dosen.index');
    }
    public function notif(){
        $dosen = Auth::user()->dosen->id;
        $inputtak= DB::table('inputtaks')
            ->join('mahasiswas','mahasiswas.id','=','inputtaks.mahasiswa_id')
            ->join('dosens', 'dosens.id', '=', 'mahasiswas.dosen_id')
            ->select('inputtaks.id','mahasiswas.mahasiswa_nama','mahasiswas.mahasiswa_image','inputtaks.updated_at','inputtaks.created_at')
            ->where('dosens.id',$dosen)
            ->where('inputtaks.inputtak_status','0')
            ->orderBy('inputtaks.updated_at','desc')
            ->take(10)
            ->get();
        $jumlah = DB::table('inputtaks')
        ->join('mahasiswas','mahasiswas.id','=','inputtaks.mahasiswa_id')
        ->join('dosens', 'dosens.id', '=', 'mahasiswas.dosen_id')
        ->where('dosens.id',$dosen)
        ->where('inputtaks.inputtak_status','0')->count();
        return response()->json(['inputtak'=>$inputtak,'jumlah'=>$jumlah]);
    }
}
