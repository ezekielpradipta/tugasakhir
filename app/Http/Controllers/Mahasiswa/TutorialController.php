<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tutorial;
use App\Models\TAK;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class TutorialController extends Controller
{
    public function index(){
        return view('mahasiswa.tutorial');
    }
    public function slider(){
        $slider = DB::table('sliders')
        ->orderBy('slider_order','asc')
        ->where('slider_jenis','inputtak')->get();
        $kategoritak = DB::table('kategoritaks')->get();
        return response()->json(['slider'=>$slider,'kategoritak'=>$kategoritak]);
    }


    public function store(Request $request){
            $nim = Auth::user()->mahasiswa->mahasiswa_nim;
            $mahasiswa_id = Auth::user()->mahasiswa->id;
            $theTAK = TAK::where("kategoritak_id",$request->kategoritak_id)
            ->where("pilartak_id",$request->pilartak_id)->where("kegiatantak_id",$request->kegiatantak_id)
            ->where("partisipasitak_id",$request->partisipasitak_id)->first();
          if ($theTAK === null){
            return back()->with('error', 'Data TAK tidak Tersedia');
          }
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
          Tutorial::create([
            'tak_id'=>$theTAK->id,
            'mahasiswa_id'=>$mahasiswa_id,
            'tutorial_penyelenggara'=>$request->penyelenggara,
            'tutorial_tanggalawal'=>$request->tanggalawal,
            'tutorial_tanggalakhir'=>$request->tanggalakhir,
            'tutorial_namaindo'=>"$request->namaindo",
            'tutorial_namainggris'=>$request->namainggris,
            'tutorial_deskripsi'=>$request->deskripsi,
            'tutorial_tahunajaran'=>$request->tahunajaran,
            'tutorial_bukti'=>$bukti,
          ]);
        
        return response()->json();

    }
}
