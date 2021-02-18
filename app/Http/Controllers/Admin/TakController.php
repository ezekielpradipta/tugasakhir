<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tak;
use App\Models\Kategoritak;
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
    public function index()
    {
        $kategoritaks =KategoriTAK::pluck('kategoritak_nama','id');
        return view('admin.tak.index',
            ['kategoritaks' =>$kategoritaks]);
        
    }
    public function tambahKategoriTak(Request $request){
        $kategoritak =Kategoritak::updateOrCreate(['id' => $request->kategori_id],
                ['kategoritak_nama' => $request->kategoritak_nama]);        

        return response()->json($kategoritak);
    }
    public function cekKategoriTak(){
        $kategoritaks =KategoriTAK::pluck('kategoritak_nama','id');
        return json_encode($kategoritaks);
    }
    public function tableKategoriTak(Request $request){
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
    public function editKategoriTak($id){
        $kategoritak = Kategoritak::find($id);
        return response()->json($kategoritak);
    }
    public function destroyKategoriTak($id){
        $kategoritak = Kategoritak::find($id)->delete();
        return response()->json($kategoritak);
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
        //
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
    public function edit(Tak $tak)
    {
        //
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
