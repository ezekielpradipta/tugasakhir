<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Inputtak;
use UxWeb\SweetAlert\SweetAlert;
use App\Models\Tak;
use App\Models\Mahasiswa;
use App\Models\Kategoritak;
use App\Models\Pilartak;
use App\Models\Kegiatantak;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Models\Partisipasitak;
use Illuminate\Http\Request;
use App\Events\TakMasuk;
class InputtakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('mahasiswa.input');

    }
    public function slider(){
        $slider = DB::table('sliders')
        ->orderBy('slider_order','asc')
        ->where('slider_jenis','inputtak')->get();
        $kategoritak = DB::table('kategoritaks')->get();
        return response()->json(['slider'=>$slider,'kategoritak'=>$kategoritak]);
    }
    public function cekPilar($id){
        $pilartaks = DB::table("pilartaks")->where("kategoritak_id",$id)->pluck("pilartak_nama","id");
        return json_encode($pilartaks);
    }
    public function cekKegiatan($id){
        $kegiatantaks = DB::table("kegiatantaks")->where("pilartak_id",$id)->pluck("kegiatantak_nama","id");
        return json_encode($kegiatantaks);
    }
    public function cekPartisipasi($id){
        $partisipasitaks = DB::table("partisipasitaks")->where("kegiatantak_id",$id)->pluck("partisipasitak_nama","id");
        return json_encode($partisipasitaks);
    }
   
    public function store(Request $request)
    {
        $this->validate($request,[
            'penyelenggara'=>['required'],
            'tahunajaran'=>['required'],
            'tanggalawal'=>['required'],
            'tanggalakhir'=>['required'],
            'namaindo'=>['required'],
            'namainggris'=>['required'],
            
        ]);
        $theTAK = TAK::where("kategoritak_id",$request->kategoritak_id)
        ->where("pilartak_id",$request->pilartak_id)->where("kegiatantak_id",$request->kegiatantak_id)
        ->where("partisipasitak_id",$request->partisipasitak_id)->first();
      if ($theTAK === null){
        return back()->with('error', 'Data TAK tidak Tersedia');
      }
      $nim = Auth::user()->mahasiswa->mahasiswa_nim;
      $mahasiswa_id = Auth::user()->mahasiswa->id;
      if($request->hasfile('bukti'))
          {
             foreach($request->file('bukti') as $bukti)
             {
                 $filename = date('YmdHis').'-'.Str::slug($nim) . '-'.$bukti->getClientOriginalName();
                 $bukti->storeAs('bukti',$filename,'images');
                 $data[] = $filename;  
             }
             $bukti=json_encode($data);
          }
          else{
              $bukti = null;
          }
         $inputtak = Inputtak::create([
            'tak_id'=>$theTAK->id,
            'mahasiswa_id'=>$mahasiswa_id,
            'inputtak_penyelenggara'=>$request->penyelenggara,
            'inputtak_tanggalawal'=>$request->tanggalawal,
            'inputtak_tanggalakhir'=>$request->tanggalakhir,
            'inputtak_namaindo'=>"$request->namaindo",
            'inputtak_namainggris'=>$request->namainggris,
            'inputtak_deskripsi'=>$request->deskripsi,
            'inputtak_tahunajaran'=>$request->tahunajaran,
            'inputtak_bukti'=>$bukti,
          ]);
     
     $mahasiswa_id = Auth::user()->mahasiswa->id;
     $mahasiswa = Mahasiswa::where('id',$mahasiswa_id)->first();
     $dosen = $mahasiswa->dosen_id;
      event(new TakMasuk($inputtak, $dosen));
      
      return response()->json();
    }
    
}
