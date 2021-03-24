<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dosen;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Inputtak;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Madzipper;
use Illuminate\Support\Facades\Storage;
use UxWeb\SweetAlert\SweetAlert;
use Illuminate\Support\Str;
class DaftarMahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $dosen = Auth::user()->dosen->id;
            $mahasiswa = DB::table('mahasiswas')
            ->join('dosens', 'dosens.id', '=', 'mahasiswas.dosen_id')
            ->leftjoin('inputtaks', 'inputtaks.mahasiswa_id', '=', 'mahasiswas.id') 
            ->leftjoin('taks', 'inputtaks.tak_id', '=', 'taks.id') 
            ->select('mahasiswas.id','mahasiswas.mahasiswa_nim','mahasiswas.mahasiswa_nama','taks.tak_score',DB::raw('sum(CASE WHEN inputtaks.inputtak_status = "1" THEN taks.tak_score ELSE 0 END)as score'))
            ->where('dosens.id',$dosen)
            
            ->groupBy('mahasiswas.id')
            ->orderBy('mahasiswas.mahasiswa_nim', 'ASC')
            ->get();
            return Datatables::of($mahasiswa)
                    ->addIndexColumn()
                    ->addColumn('action',function($mahasiswa)  {
                        $btn_bukti = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$mahasiswa->id.'" data-original-title="Show" class="btn btn-success btn-sm show-Tak"><span class="fa fa-eye"></a>';
                        return $btn_bukti;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            

        }
        return view('dosen.daftarmahasiswa.index');
    }

    public function tbTak(Request $request){
        if($request->ajax()){
            $mahasiswa = $request->mahasiswa;
            $inputtaks = DB::table('inputtaks')->join('taks','taks.id','=','inputtaks.tak_id')
            ->join('kegiatantaks','kegiatantaks.id','=','taks.kegiatantak_id')
            ->join('partisipasitaks','partisipasitaks.id','=','taks.partisipasitak_id')
            ->join ('mahasiswas','mahasiswas.id','=','inputtaks.mahasiswa_id')
            ->select('inputtaks.id','kegiatantaks.kegiatantak_nama','partisipasitaks.partisipasitak_nama','taks.tak_score','inputtaks.inputtak_deskripsi','inputtaks.inputtak_status')
            ->where('mahasiswas.id',$mahasiswa)
            ->where('inputtaks.inputtak_status', '1')->get();
           
            return Datatables::of($inputtaks)
                    ->addIndexColumn()
                    ->addColumn('action', function($inputtaks){
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$inputtaks->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm btn-edit"><span class="fa fa-eye"></a>';
                           $btn2= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$inputtaks->id.'" data-original-title="Status" class="edit btn btn-danger btn-sm btn-status"><span class="fa fa-ban"></span>Batal ACC</a>';
                            return $btn.$btn2;
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
    
    }
    public function edit($id)
    {
        $mahasiswa = Mahasiswa::with('inputtak')->find($id);
        $id = $mahasiswa->id;
        
        return response()->json(['mahasiswa'=>$mahasiswa,'id'=>$id]);
    }
    public function editTak($id){
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
        $inputtak->inputtak_status = '0';
        $inputtak->save();
        return response()->json();
    }
   
}
