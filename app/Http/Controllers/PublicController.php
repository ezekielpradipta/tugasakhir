<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tak;
use App\Models\Kategoritak;
use App\Models\Pilartak;
use App\Models\Kegiatantak;
use App\Models\Partisipasitak;
use App\Models\User;
use App\Models\Prodi;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Angkatan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
class PublicController extends Controller
{
    public function cekEmail(Request $request){
    	if($request->get('email')){
    		$email = $request->get('email');
    		$data =DB::table("users")->where('email',$email)->count();
    			if($data >0){
    				echo "not_unique";
    			} else {
    				echo "unique";
    			}
    	}
    }
    public function cekUsername(Request $request){
    	if($request->get('username')){
    		$username = $request->get('username');
    		$data =DB::table("users")->where('username',$username)->count();
    			if($data >0){
    				echo "not_unique";
    			} else {
    				echo "unique";
    			}
    	}
    }
    public function cekNIDN(Request $request){
    	if($request->get('nidn')){
    		$nidn = $request->get('nidn');
    		$data =DB::table("dosens")->where('nidn',$nidn)->count();
    			if($data >0){
    				echo "not_unique";
    			} else {
    				echo "unique";
    			}
    	}
    }
    public function cekNim(Request $request){
    	if($request->get('nim')){
    		$nim = $request->get('nim');
    		$data =DB::table("mahasiswas")->where('mahasiswa_nim',$nim)->count();
    			if($data >0){
    				echo "not_unique";
    			} else {
    				echo "unique";
    			}
    	}
    }
    public function getDosen(){
        $dosen =Dosen::where('dosen_status','dosenwali')->pluck('dosen_nama','id');
        return json_encode($dosen);
    }
    public function getAngkatan(){
        $angkatan =Angkatan::pluck('angkatan_tahun','id');
        return json_encode($angkatan);
    }
    public function getProdi(){
        $prodi =Prodi::pluck('prodi_nama','id');
        return json_encode($prodi);
    }
    public function getKategoriTak(){
        $kategoritaks =Kategoritak::pluck('kategoritak_nama','id');
        return json_encode($kategoritaks);
    }
    public function getPilarTak(){
        
        $pilartak =Pilartak::pluck('pilartak_nama','id');
        return json_encode($pilartak);
    }
    public function getKegiatanTak(){
        
        $kegiatantak =Kegiatantak::pluck('kegiatantak_nama','id');
        return json_encode($kegiatantak);
    }
    public function getPartisipasiTak(){
        
        $partisipasitak =Partisipasitak::pluck('partisipasitak_nama','id');
        return json_encode($partisipasitak);
    }
    public function getPilarTakById($id){
        $pilartaks = DB::table("pilartaks")->where("kategoritak_id",$id)->pluck("pilartak_nama","id");
        return json_encode($pilartaks);
    }
    public function getKegiatanTakById($id){
        $kegiatantaks = DB::table("kegiatantaks")->where("pilartak_id",$id)->pluck("kegiatantak_nama","id");
        return json_encode($kegiatantaks);
    }
    public function getPartisipasiTakById($id){
        $partisipasitaks = DB::table("partisipasitaks")->where("kegiatantak_id",$id)->pluck("partisipasitak_nama","id");
        return json_encode($partisipasitaks);
    }
}
