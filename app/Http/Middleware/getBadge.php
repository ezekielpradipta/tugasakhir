<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Badge;
use Illuminate\Support\Facades\DB;
use UxWeb\SweetAlert\SweetAlert;
class getBadge
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $mahasiswa = Auth::user()->mahasiswa->id;
        $mhs = Mahasiswa::find($mahasiswa);
        $angkatan = $mhs->angkatan_id;
        $prodi = $mhs->prodi_id;
        $mahasiswa_badge_id = $mhs->badge_id;
        $badge = Badge::where('id',$mahasiswa_badge_id)->first();
        $badge_image= $badge->badge_image;
        $tak_kumulatif = DB::table('takkumulatifs')->where('angkatan_id',$angkatan)->where('prodi_id',$prodi)->first();
        $poinGold = $tak_kumulatif->poinminimum;
        $poinBronze = $poinGold/3;
        $poinSilver = $poinBronze *2;
        $total_tak = DB::table('notif_tak_masuks')
        ->join('mahasiswas','mahasiswas.id','=','notif_tak_masuks.mahasiswa_id')
        ->join('inputtaks','inputtaks.id','=','notif_tak_masuks.inputtak_id')
        ->join('taks','taks.id','=','inputtaks.tak_id') 
        ->where('mahasiswas.id',$mahasiswa)
        ->where('notif_tak_masuks.notif_tak_read','1')
        ->sum('taks.tak_score');
        $score =(int)$total_tak;
        
        $mhs_badge_nama= $badge->badge_nama;
        if($score>=$poinBronze && $score <$poinSilver && $score <$poinGold){
            $next_badge= Badge::where('badge_nama','bronze')->first();
            $next_badge_nama = $next_badge->badge_nama;
            if($next_badge_nama != $mhs_badge_nama){
                $get_badge='ganti_badge_bronze';
            }else{
                $get_badge='no';
            }
            
        }elseif($score>=$poinSilver && $score <$poinGold){
            $next_badge= Badge::where('badge_nama','silver')->first();
            $next_badge_nama = $next_badge->badge_nama;
            if($next_badge_nama != $mhs_badge_nama){
                $get_badge='ganti_badge_silver';
            }else{
                $get_badge='no';
            }
        }elseif($score>=$poinGold){
            $next_badge= Badge::where('badge_nama','gold')->first();
            $next_badge_nama = $next_badge->badge_nama;
            if($next_badge_nama != $mhs_badge_nama){
                $get_badge='ganti_badge_gold';
                
            }else{
                $get_badge='no';
            }
        } else{
            $get_badge='no';
        }
        if($get_badge !='no'){
            alert()->warning('Mohon untuk Mengecek Notifikasi', 'Opss');
            return redirect()->route('mahasiswa.index');
        }
        return $next($request);
    }
}
