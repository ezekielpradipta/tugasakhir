<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tak;
use App\Models\Kategoritak;
use App\Models\Pilartak;
use App\Models\Kegiatantak;

use App\Models\Partisipasitak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
class TakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $taks = Tak::with('kegiatantak','partisipasitak')->latest()->get();
            return Datatables::of($taks)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm tak-edit"><span class="fa fa-pencil"></a>';
                            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm tak-delete"><span class="fa fa-trash"></a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.tak.index');
        
    }
    
    public function tbTak(Request $request){
        
        
    
    }
    public function tambahKategori(Request $request){
        $kategoritak =Kategoritak::updateOrCreate(['id' => $request->kategori_id],
                ['kategoritak_nama' => $request->kategoritak_nama]);        

        return response()->json($kategoritak);
    }
    public function tambahPilar(Request $request){
        $pilartak =Pilartak::updateOrCreate(['id' => $request->pilar_id],
                ['kategoritak_id' => $request->pilar_kategoriselected,
                'pilartak_nama' => $request->pilartak_nama]
            );        

        return response()->json($pilartak);
    }
    public function tambahKegiatan(Request $request){
        $this->validate($request,[
            'kegiatantak_nama' => ['required'],
        ]);
        $kegiatantak =Kegiatantak::updateOrCreate(['id' => $request->kegiatan_id],
                ['pilartak_id' => $request->kegiatan_pilarselected,
                'kegiatantak_nama' => $request->kegiatantak_nama]
            );        

        return response()->json();
    }
    public function tambahPartisipasi(Request $request){
        $this->validate($request,[
            'partisipasitak_nama' => ['required'],
        ]);
        $partisipasitak =Partisipasitak::updateOrCreate(['id' => $request->partisipasi_id],
                [
                'kegiatantak_id' => $request->partisipasi_kegiatanselected,
                'partisipasitak_nama' => $request->partisipasitak_nama]
            );        

        return response()->json();
    }
    public function tbKategori(Request $request){
        if($request->ajax()){
            $kategoritak = Kategoritak::latest()->get();
            return Datatables::of($kategoritak)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm kategoritak-edit"><span class="fa fa-pencil"></a>';
                            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm kategoritak-delete"><span class="fa fa-trash"></a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    
    }
    public function tbPilar(Request $request){
        if($request->ajax()){
            $pilartak = Pilartak::with('kategoritak')->latest()->get();
            return Datatables::of($pilartak)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm pilartak-edit"><span class="fa fa-pencil"></a>';
                            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm pilartak-delete"><span class="fa fa-trash"></a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    
    }
    public function tbKegiatan(Request $request){
        if($request->ajax()){
            $kegiatantak = Kegiatantak::with('pilartak')->latest()->get();
            return Datatables::of($kegiatantak)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm kegiatantak-edit"><span class="fa fa-pencil"></a>';
                            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm kegiatantak-delete"><span class="fa fa-trash"></a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    
    }
    public function tbPartisipasi(Request $request){
        if($request->ajax()){
            $partisipasitak = DB::table('partisipasitaks')
            ->join('kegiatantaks', 'kegiatantaks.id', '=', 'partisipasitaks.kegiatantak_id')
            ->select('partisipasitaks.id','kegiatantaks.kegiatantak_nama','partisipasitaks.partisipasitak_nama')
            ->get();
            return Datatables::of($partisipasitak)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm partisipasitak-edit"><span class="fa fa-pencil"></a>';
                            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm partisipasitak-delete"><span class="fa fa-trash"></a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    
    }
    public function editKategori($id){
        $kategoritak = Kategoritak::find($id);
        return response()->json($kategoritak);
    }
    public function editPilar($id){
        $pilartak = Pilartak::with('kategoritak')->find($id);
        return response()->json($pilartak);
    }
    public function editKegiatan($id){
        $kegiatantak = Kegiatantak::with('pilartak')->find($id);    
        return response()->json($kegiatantak);
    }
    public function editPartisipasi($id){
        $partisipasitak = Partisipasitak::with('kegiatantak')->find($id);    
        return response()->json($partisipasitak);
    }
    
    public function deleteKategori($id){
        $kategoritak = Kategoritak::find($id)->delete();
        return response()->json($kategoritak);
    }
    public function deletePilar($id){
        $pilartak = Pilartak::with('kategoritak')->find($id)->delete();
        return response()->json($pilartak);
    }
    public function deleteKegiatan($id){
        $kegiatantak = Kegiatantak::with('pilartak')->find($id)->delete();   
                
        return response()->json($kegiatantak);
    }
    public function deletePartisipasi($id){
        $partisipasitak = Partisipasitak::with('kegiatantak')->find($id)->delete();    
 
                
        return response()->json($partisipasitak);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            'tak_score' => ['required'],
        ]);
        $taks =Tak::updateOrCreate(['id' => $request->tak_id],
                [
                'kategoritak_id' => $request->kategori_val,
                'pilartak_id' => $request->pilar_val,
                'kegiatantak_id' => $request->kegiatan_val,
                'partisipasitak_id'=>$request->partisipasi_val,
                'tak_score' => $request->tak_score,
                
                ]

            );        

        return response()->json();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tak  $tak
     * @return \Illuminate\Http\Response
     */
    public function show(Tak $tak)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tak  $tak
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $taks = Tak::with('kegiatantak','partisipasitak','pilartak','kategoritak')->find($id);
        $kategoritak_id = $taks->kategoritak_id;
        $pilartak_id = $taks->pilartak_id;
        $kegiatantak_id = $taks->kegiatantak_id;
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
        return response()->json(['taks'=>$taks,'pilartaks'=>$pilartaks,'kegiatantaks'=>$kegiatantaks,'partisipasitaks'=>$partisipasitaks]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tak  $tak
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tak $tak)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tak  $tak
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tak $tak)
    {
        //
    }
}
