<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inputtak;
use App\Models\Kategoritak;
use App\Models\Pilartak;
use App\Models\Kegiatantak;
use App\Models\Tak;
use App\Models\Mahasiswa;
use App\Models\Partisipasitak;
use UxWeb\SweetAlert\SweetAlert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Madzipper;
use App\Events\TakMasuk;
class DaftartakController extends Controller
{
    public function adaPilar($id){
        $pilartaks = DB::table("pilartaks")->where("kategoritak_id",$id)->pluck("pilartak_nama","id");
        return json_encode($pilartaks);
    }
    public function adaKegiatan($id){
        $kegiatantaks = DB::table("kegiatantaks")->where("pilartak_id",$id)->pluck("kegiatantak_nama","id");
        return json_encode($kegiatantaks);
    }
    public function adaPartisipasi($id){
        $partisipasitaks = DB::table("partisipasitaks")->where("kegiatantak_id",$id)->pluck("partisipasitak_nama","id");
        return json_encode($partisipasitaks);
    }
    public function cekKategori(){
        $kategoritaks =Kategoritak::pluck('kategoritak_nama','id');
        return json_encode($kategoritaks);
    }
    public function cekPilar(){
        
        $pilartak =Pilartak::pluck('pilartak_nama','id');
        return json_encode($pilartak);
    }
    public function cekKegiatan(){
        
        $kegiatantak =Kegiatantak::pluck('kegiatantak_nama','id');
        return json_encode($kegiatantak);
    }
    public function cekPartisipasi(){
        
        $partisipasitak =Partisipasitak::pluck('partisipasitak_nama','id');
        return json_encode($partisipasitak);
    }
    public function index(Request $request){
        if($request->ajax()){
            
            $mahasiswa = Auth::user()->id;
            
            $status = $request->status;

            $inputtaks = DB::table('inputtaks')->join('taks','taks.id','=','inputtaks.tak_id')
            ->join('kegiatantaks','kegiatantaks.id','=','taks.kegiatantak_id')
            ->join('partisipasitaks','partisipasitaks.id','=','taks.partisipasitak_id')
            ->join ('mahasiswas','mahasiswas.id','=','inputtaks.mahasiswa_id')
            ->join ('users','users.id','=','mahasiswas.user_id')
            ->select('inputtaks.id','kegiatantaks.kegiatantak_nama','partisipasitaks.partisipasitak_nama','taks.tak_score','inputtaks.inputtak_deskripsi','inputtaks.inputtak_status')
            ->where('users.id',$mahasiswa)
            ->where('inputtaks.inputtak_status', $status)->get()
            ;
            return Datatables::of($inputtaks)->addIndexColumn()
            ->addColumn('action',function($inputtaks){
                $btn_edit = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$inputtaks->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm edit-Input"><span class="fa fa-pencil"></a>';
                $btn_hapus = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$inputtaks->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete-input"><span class="fa fa-trash"></a>';
                $btn_show = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$inputtaks->id.'" data-original-title="Show" class="btn btn-success btn-sm show-input"><span class="fa fa-eye"></a>';
                if ($inputtaks->inputtak_status==Inputtak::TAK_BLUM_DIACC)
                    {
                        return $btn_edit.$btn_hapus;
                    }else
                    {
                        return $btn_show;
                    }
            })
            ->addColumn('bukti', function($inputtaks){
                $btn_bukti = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$inputtaks->id.'" data-original-title="Show" class="btn btn-success btn-sm show-Bukti"><span class="fa fa-image"></a>';
                return $btn_bukti;
               
           })
           ->editColumn('nama',function($inputtaks){
            return  $inputtaks->kegiatantak_nama.'- ('. $inputtaks->partisipasitak_nama. ')' ;
            })
            
            ->rawColumns(['action','bukti','nama'])
            ->make(true);
        }
        return view('mahasiswa.daftartak');
    }
    public function getBukti($id){
        $inputtaks = Inputtak::with('tak.kegiatantak')
        ->with('tak.kategoritak')
        ->with('tak.partisipasitak')
        ->with('tak.kegiatantak')
        ->with('tak.pilartak')
        ->find($id);
        $images =json_decode($inputtaks->inputtak_bukti);
        $status = $inputtaks->inputtak_status;
        if($images){
            if($status ==Inputtak::TAK_BLUM_DIACC){
                return response()->json(['inputtaks'=>$inputtaks,'images'=>$images,'status'=>'false','gambar'=>'ada']);
            }
            else{
                return response()->json(['inputtaks'=>$inputtaks,'images'=>$images,'status'=>'true','gambar'=>'ada']);
            }
        }
        else{
            return response()->json(['inputtaks'=>$inputtaks,'gambar'=>'null']);
        }
       
    }
    public function edit($id){
        $inputtaks = Inputtak::with('tak.kegiatantak')
        ->with('tak.kategoritak')
        ->with('tak.partisipasitak')
        ->with('tak.kegiatantak')
        ->with('tak.pilartak')
        ->find($id);
        $kategoritak_id = $inputtaks->tak->kategoritak_id;
        $pilartak_id = $inputtaks->tak->pilartak_id;
        $kegiatantak_id = $inputtaks->tak->kegiatantak_id;
        $pilartaks = DB::table('pilartaks')
        ->join('kategoritaks','kategoritaks.id','=','pilartaks.kategoritak_id')
        ->where('kategoritaks.id',$kategoritak_id)
        ->pluck('pilartaks.pilartak_nama','pilartaks.id')
        ;
        $kegiatantaks = DB::table('kegiatantaks')
        ->join('pilartaks','pilartaks.id','=','kegiatantaks.pilartak_id')
        ->where('pilartaks.id',$pilartak_id)
        ->pluck('kegiatantaks.kegiatantak_nama','kegiatantaks.id')
        ;
        $partisipasitaks = DB::table('partisipasitaks')
        ->join('kegiatantaks','kegiatantaks.id','=','partisipasitaks.kegiatantak_id')
        ->where('kegiatantaks.id',$kegiatantak_id)
        ->pluck('partisipasitaks.partisipasitak_nama','partisipasitaks.id')
        ;
        return response()->json(['inputtaks'=>$inputtaks,'pilartaks'=>$pilartaks,'kegiatantaks'=>$kegiatantaks,'partisipasitaks'=>$partisipasitaks]);
    }
    public function store(Request $request){
        $theTAK = Tak::where("kategoritak_id",$request->kategori_val)
        ->where("pilartak_id",$request->pilar_val)->where("kegiatantak_id",$request->kegiatan_val)
        ->where("partisipasitak_id",$request->partisipasi_val)->first();
      if ($theTAK === null){
        return back()->with('error', 'Data TAK tidak Tersedia');
      }
      $inputak= Inputtak::where('id',$request->inputtak_id)->update(
        [   'tak_id'=>$theTAK->id,
            'inputtak_penyelenggara'=>$request->penyelenggara,
            'inputtak_tanggalawal'=>$request->tanggalawal,
            'inputtak_tanggalakhir'=>$request->tanggalakhir,
            'inputtak_namaindo'=>"$request->namaindo",
            'inputtak_namainggris'=>$request->namainggris,
            'inputtak_deskripsi'=>$request->deskripsi,
            'inputtak_tahunajaran'=>$request->tahunajaran,
        ]);
       
        return response()->json();
    }
    public function destroy($id){
        $inputtaks = Inputtak::find($id);
        //$images = explode(",", $inputtaks->inputtak_bukti);
        $images =json_decode($inputtaks->inputtak_bukti);
        if($images){
            foreach ($images as $image) {
                Storage::disk('images')->delete("bukti/{$image}");
             }
        }
        $inputtaks->delete();
        return response()->json([$inputtaks,$images]);
    }
    public function cetakBukti($fileId){
        $inputtak = Inputtak::with('mahasiswa')->findOrFail($fileId);
        $images =json_decode($inputtak->inputtak_bukti);
        $nim= $inputtak->mahasiswa->mahasiswa_nim;
        Storage::disk('images')->delete("Bukti-TAK-{$nim}.zip");
        $zipper = Madzipper::make(public_path("/img/Bukti-TAK-{$nim}.zip"));
        foreach ($images as $file) {
            $zipper->add(public_path("/img/bukti/{$file}")); // update it by your path
        }
        $zipper->close();
       // Madzipper::make(public_path("/img/Bukti-TAK-{$nim}.zip"))->add([public_path('img/contoh.png')])->close();
        return response()->download(public_path("img/Bukti-TAK-{$nim}.zip"));    
    }
    public function editBukti($id){
        $inputtak = Inputtak::with('mahasiswa')->find($id);
        return response()->json($inputtak);
    }
    public function tambahBukti(Request $request)
    {
        $gambar = Inputtak::where('id',$request->input_id2)->first();
        $images =json_decode($gambar->inputtak_bukti);
        if($images){
            foreach ($images as $image) {
                Storage::disk('images')->delete("bukti/{$image}");
             }
        }
        $nim = Auth::user()->mahasiswa->mahasiswa_nim;
        if($request->hasfile('bukti'))
      {

         foreach($request->file('bukti') as $bukti)
         {
             $filename = date('YmdHis').'-'.Str::slug($nim) . '-'.$bukti->getClientOriginalName();
             $bukti->storeAs('bukti',$filename,'images');
             $data[] = $filename;  
         }
         $sudah_array= json_encode($data);
      } else{
          $sudah_array="";
      }
      
      $inputak= Inputtak::where('id',$request->input_id2)->update(
        [  
            'inputtak_bukti'=>$sudah_array,
        ]);
        
      return response()->json();
    }

}
