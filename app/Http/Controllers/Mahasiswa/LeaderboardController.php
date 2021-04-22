<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $mhs_angkatan = Auth::user()->mahasiswa->angkatan_id;
            $mhs_prodi = Auth::user()->mahasiswa->prodi_id;
            $leaderboard = DB::table('mahasiswas')
            ->leftjoin('notif_tak_masuks','mahasiswas.id','=','notif_tak_masuks.mahasiswa_id')
            ->leftjoin('inputtaks','inputtaks.id','=','notif_tak_masuks.inputtak_id')
            ->leftjoin('taks','taks.id','=','inputtaks.tak_id')
            ->join('badges','badges.id','=','mahasiswas.badge_id')
            ->select('mahasiswas.id','mahasiswas.mahasiswa_nama','mahasiswas.mahasiswa_image','badges.badge_image','taks.tak_score',DB::raw('sum(CASE WHEN inputtaks.inputtak_status = "1" THEN taks.tak_score ELSE 0 END)as score'))
            ->where('mahasiswas.angkatan_id',$mhs_angkatan)
            ->where('mahasiswas.prodi_id',$mhs_prodi)
            ->orderBy('score','desc')
            ->groupBy('mahasiswas.id')
            ->take(20)
            ->get();
            return Datatables::of($leaderboard)
                    ->addIndexColumn()
                    ->editColumn('nama',function($leaderboard){
                        return '<img class="notif-badge" src="../../img/'.$leaderboard->badge_image.'" />'.
                        '<img style="width: 50px; margin-right: 10px;" src="../../img/'.$leaderboard->mahasiswa_image.'" />'.$leaderboard->mahasiswa_nama;
                    })
                    ->rawColumns(['nama'])
                    ->make(true);
            
        }
        return view('mahasiswa.leaderboard');
    }
}
