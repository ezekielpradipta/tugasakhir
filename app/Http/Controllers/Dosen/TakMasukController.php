<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dosen;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Inputtak;
use App\Models\Kategoritak;
use App\Models\Pilartak;
use App\Models\Kegiatantak;
use App\Models\Tak;
use App\Models\Partisipasitak;
use UxWeb\SweetAlert\SweetAlert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Madzipper;

class TakMasukController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $dosen = Auth::user()->dosen->id;
           
            $inputtak= DB::table('inputtaks')
            ->join('mahasiswas','mahasiswas.id','=','inputtaks.mahasiswa_id')
            ->join('dosens', 'dosens.id', '=', 'mahasiswas.dosen_id')
            ->join('taks', 'inputtaks.tak_id', '=', 'taks.id') 
            ->join('kegiatantaks', 'taks.kegiatantak_id', '=', 'kegiatantaks.id')
            ->join('partisipasitaks','partisipasitaks.id','=','taks.partisipasitak_id') 
            ->select('inputtaks.id','mahasiswas.mahasiswa_nim','mahasiswas.mahasiswa_nama','kegiatantaks.kegiatantak_nama','partisipasitaks.partisipasitak_nama','taks.tak_score','inputtaks.inputtak_deskripsi')
            ->where('dosens.id',$dosen)
            ->where('inputtaks.inputtak_status','0')
            ->get();
            return Datatables::of($inputtak)
                    ->addIndexColumn()
                    ->addColumn('action',function($inputtak)  {
                        $btn_bukti = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$inputtak->id.'" data-original-title="Show" class="btn btn-primary btn-sm btn-edit"><span class="fa fa-eye"title="Lihat Detail"></a>';
                        $btn_hapus =' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$inputtak->id.'" data-original-title="Show" class="btn btn-danger btn-sm btn-delete"><span class="fa fa-trash" title="Hapus TAK"></a>';
                        $btn_status =' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$inputtak->id.'" data-original-title="Show" class="btn btn-success btn-sm btn-status"><span class="fa fa-check" title="ACC TAK"></a>';
                        return $btn_bukti.$btn_status.$btn_hapus;
                    })
                    ->editColumn('nama',function($inputtak){
                        return  $inputtak->kegiatantak_nama.'- ('. $inputtak->partisipasitak_nama. ')' ;
                        })
                    ->addColumn('bukti', function($inputtak){
                            $btn_bukti = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$inputtak->id.'" data-original-title="Show" class="btn btn-success btn-sm show-Bukti"><span class="fa fa-image" title="Lihat Bukti TAK"></a>';
                            return $btn_bukti;
                           
                       })
                    ->rawColumns(['action','nama','bukti'])
                    ->make(true);
            

        }
        return view('dosen.takmasuk');
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
    public function cetakBukti($fileId){
        $inputtak = Inputtak::with('mahasiswa')->findOrFail($fileId);
        $images =json_decode($inputtak->inputtak_bukti);
        $nim= $inputtak->mahasiswa->mahasiswa_nim;
        Storage::disk('images')->delete("Bukti-TAK-{$nim}.zip");
        $files = glob(public_path('img/contoh3.png'));
        $zipper = Madzipper::make(public_path("/img/Bukti-TAK-{$nim}.zip"));
        foreach ($images as $file) {
            $zipper->add(public_path("/img/bukti/{$file}")); // update it by your path
        }
        $zipper->close();
       // Madzipper::make(public_path("/img/Bukti-TAK-{$nim}.zip"))->add([public_path('img/contoh.png')])->close();
        return response()->download(public_path("img/Bukti-TAK-{$nim}.zip"));    
    }
    public function gantiStatus($id){
        $inputtak = Inputtak::with('mahasiswa')->findOrFail($id);
        $inputtak->inputtak_status = '1';
        $inputtak->save();
        return response()->json();
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
        $kategoritaks= DB::table('kategoritaks')->where('kategoritaks.id',$kategoritak_id)
        ->pluck('kategoritaks.kategoritak_nama','kategoritaks.id');
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
        return response()->json(['kategoritaks'=>$kategoritaks, 'inputtaks'=>$inputtaks,'pilartaks'=>$pilartaks,'kegiatantaks'=>$kegiatantaks,'partisipasitaks'=>$partisipasitaks]);
    }
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
}
