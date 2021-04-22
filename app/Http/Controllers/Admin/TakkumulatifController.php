<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Takkumulatif;
use App\Models\Angkatan;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
class TakkumulatifController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $tak = Takkumulatif::with('angkatan','prodi')->latest()->get();
            return Datatables::of($tak)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editItem"><span class="fa fa-pencil"></a>';
                            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteItem"><span class="fa fa-trash"></a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.takkumulatif.index');
    }
    public function getData(){
        $angkatan = Angkatan::latest()->get();
        $prodi = Prodi::latest()->get();
        return response()->json(['angkatan'=>$angkatan,'prodi'=>$prodi]);
    }
    public function store(Request $request)
    {
        $tak =Takkumulatif::updateOrCreate(['id' => $request->takkumulatif_id],
        ['angkatan_id' => $request->angkatan,
        'prodi_id' => $request->prodi,
        'poinminimum' => $request->poinminimum,
        ]);
        return response()->json();    
    }
    public function edit($id){
        $tak = Takkumulatif::find($id);
        return response()->json($tak);
    }
    public function destroy($id){
        $tak = Takkumulatif::find($id)->delete();
        return response()->json();
    }
}
