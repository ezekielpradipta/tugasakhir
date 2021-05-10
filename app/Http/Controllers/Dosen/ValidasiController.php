<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dosen;
use App\Models\User;
use App\Models\NotifTakMasuk;
use App\Models\Mahasiswa;
use App\Models\Inputtak;
use App\Models\ValidasiTak;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Madzipper;
use Illuminate\Support\Facades\Storage;
use UxWeb\SweetAlert\SweetAlert;
use Illuminate\Support\Str;
class ValidasiController extends Controller
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
            $status = $request->status;
            $validasi = DB::table('validasi_taks')
            ->join('mahasiswas','mahasiswas.id','=','validasi_taks.mahasiswa_id')
            ->join('dosens', 'dosens.id', '=', 'validasi_taks.dosen_id')
            ->select('validasi_taks.id','validasi_taks.validasi_status','mahasiswas.mahasiswa_nama','validasi_taks.mahasiswa_id','dosens.dosen_nama','mahasiswas.mahasiswa_nim')
            ->where('validasi_taks.validasi_status',$status)
            ->get();
            return Datatables::of($validasi)->addIndexColumn()
            ->addColumn('action',function($validasi){
                if($validasi->validasi_status =='0'){
                    $btn_cek = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$validasi->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm btn-cek"><span class="fa fa-check"></a>';
                    $btn_show = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$validasi->mahasiswa_id.'" data-original-title="Show" class="btn btn-success btn-sm btn-show"><span class="fa fa-eye"></a>';
                   return $btn_show. $btn_cek;
                } else{
                    $btn_show = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$validasi->mahasiswa_id.'" data-original-title="Show" class="btn btn-success btn-sm btn-show"><span class="fa fa-eye"></a>';
                   return $btn_show;
                }
                
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('dosen.validasi.index');
    }

   public function validasi($id)
   {
       $validasi = ValidasiTak::find($id);
       $validasi->validasi_status = '1';
       $validasi->save();

       return response()->json();
   }
}
