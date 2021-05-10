<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inputtak;
use App\Models\Dosen;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{
    public function dashboard(){
        
        return view('dosen.index');
    }
    public function notif(){
        $dosen_id = Auth::user()->dosen->id;
        $dosen = Dosen::find($dosen_id);
        $dosen_status =$dosen->dosen_status;
        if($dosen_status =="dosenwali"){
            $inputtak= DB::table('inputtaks')
            ->join('mahasiswas','mahasiswas.id','=','inputtaks.mahasiswa_id')
            ->join('dosens', 'dosens.id', '=', 'mahasiswas.dosen_id')
            ->select('inputtaks.id','mahasiswas.mahasiswa_nama','mahasiswas.mahasiswa_image','inputtaks.updated_at','inputtaks.created_at')
            ->where('dosens.id',$dosen_id)
            ->where('inputtaks.inputtak_status','0')
            ->orderBy('inputtaks.updated_at','desc')
            ->take(10)
            ->get();
        $jumlah = DB::table('inputtaks')
        ->join('mahasiswas','mahasiswas.id','=','inputtaks.mahasiswa_id')
        ->join('dosens', 'dosens.id', '=', 'mahasiswas.dosen_id')
        ->where('dosens.id',$dosen_id)
        ->where('inputtaks.inputtak_status','0')->count();
        $validasi =0;
        } else{
            $inputtak= DB::table('inputtaks')
            ->join('mahasiswas','mahasiswas.id','=','inputtaks.mahasiswa_id')
            ->join('dosens', 'dosens.id', '=', 'mahasiswas.dosen_id')
            ->select('inputtaks.id','mahasiswas.mahasiswa_nama','mahasiswas.mahasiswa_image','inputtaks.updated_at','inputtaks.created_at')
            ->where('inputtaks.inputtak_status','0')
            ->orderBy('inputtaks.updated_at','desc')
            ->take(10)
            ->get();
            $jumlah = $inputtak->count();
            $validasi = DB::table('validasi_taks')
            ->join('mahasiswas','mahasiswas.id','=','validasi_taks.mahasiswa_id')
            ->join('dosens', 'dosens.id', '=', 'validasi_taks.dosen_id')
            ->select('validasi_taks.id','mahasiswas.mahasiswa_nama','dosens.dosen_nama','dosens.dosen_image','validasi_taks.updated_at')
            ->where('validasi_taks.validasi_status','0')
            ->orderBy('validasi_taks.updated_at','desc')
            ->get();
        }
        
        return response()->json(['dosen_status'=>$dosen_status,'inputtak'=>$inputtak,'jumlah'=>$jumlah,'validasi'=>$validasi]);
    }
}
