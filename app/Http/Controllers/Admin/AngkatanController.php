<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Angkatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
class AngkatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $angkatan = Angkatan::latest()->get();
            return Datatables::of($angkatan)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editItem"><span class="fa fa-pencil"></a>';
                            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteItem"><span class="fa fa-trash"></a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.angkatan.index');
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
            'angkatan_tahun' => ['required', 'numeric', 'digits:4','unique:angkatans,angkatan_tahun']
        ]);
        $angkatan =Angkatan::updateOrCreate(['id' => $request->angkatan_id],
                ['angkatan_tahun' => $request->angkatan_tahun]);        

        return response()->json();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Angkatan  $angkatan
     * @return \Illuminate\Http\Response
     */
    public function show(Angkatan $angkatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Angkatan  $angkatan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $angkatan = Angkatan::find($id);
        return response()->json($angkatan);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Angkatan  $angkatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Angkatan $angkatan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Angkatan  $angkatan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $angkatan = Angkatan::find($id)->delete();
        return response()->json($angkatan);
    }
}
