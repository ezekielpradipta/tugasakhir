<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Inputtak;
use UxWeb\SweetAlert\SweetAlert;
use App\Models\Tak;
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
        $kategoritaks =Kategoritak::pluck('kategoritak_nama','id');
        return view('mahasiswa.input',
            ['kategoritaks' =>$kategoritaks]);

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
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'penyelenggara'=>['required'],
            'tahunajaran'=>['required'],
            'tanggalawal'=>['required'],
            'tanggalakhir'=>['required'],
            'namaindo'=>['required'],
            'namainggris'=>['required'],
            'bukti.*' => 'mimes:png,pdf,jpg',
        ]);
        $theTAK = TAK::where("kategoritak_id",$request->kategoritak_id)
        ->where("pilartak_id",$request->pilartak_id)->where("kegiatantak_id",$request->kegiatantak_id)
        ->where("partisipasitak_id",$request->partisipasitak_id)->first();
      if ($theTAK === null){
        return back()->with('error', 'Data TAK tidak Tersedia');
      }
      $takmahasiswa = new Inputtak;
      $takmahasiswa->mahasiswa_id = Auth::user()->mahasiswa->id;
      $takmahasiswa->inputtak_penyelenggara = $request->penyelenggara;
      $takmahasiswa->tak_id = $theTAK->id;
      $takmahasiswa->inputtak_tahunajaran = $request->tahunajaran;
      $takmahasiswa->inputtak_deskripsi = $request->deskripsi;
      $takmahasiswa->inputtak_tanggalawal = $request->tanggalawal;
      $takmahasiswa->inputtak_namaindo = $request->namaindo;
      $takmahasiswa->inputtak_namainggris = $request->namainggris;
      $takmahasiswa->inputtak_tanggalakhir = $request->tanggalakhir;
      $nim = Auth::user()->mahasiswa->mahasiswa_nim;
      if($request->hasfile('bukti'))
      {

         foreach($request->file('bukti') as $bukti)
         {
             $filename = date('YmdHis').'-'.Str::slug($nim) . '-'.$bukti->getClientOriginalName();
             $bukti->storeAs('bukti',$filename,'images');
             $data[] = $filename;  
         }
         $takmahasiswa->inputtak_bukti=json_encode($data);
      }
     
      $takmahasiswa->save();
      event(new TakMasuk($takmahasiswa));
      return redirect()->back()->with('success', 'TAK Berhasil Disubmit!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inputtak  $inputtak
     * @return \Illuminate\Http\Response
     */
    public function show(Inputtak $inputtak)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inputtak  $inputtak
     * @return \Illuminate\Http\Response
     */
    public function edit(Inputtak $inputtak)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inputtak  $inputtak
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inputtak $inputtak)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inputtak  $inputtak
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inputtak $inputtak)
    {
        //
    }
}
