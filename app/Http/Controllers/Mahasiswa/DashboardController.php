<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NotifTakMasuk;
use App\Models\Mahasiswa;
use App\Models\Dosen;

use App\Models\Tutorial;
use App\Models\Badge;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{
    public function index(){
        $mahasiswa = Auth::user()->mahasiswa->id;
        $score = DB::table('notif_tak_masuks')
        ->join('mahasiswas','mahasiswas.id','=','notif_tak_masuks.mahasiswa_id')
        ->join('inputtaks','inputtaks.id','=','notif_tak_masuks.inputtak_id')
        ->join('taks','taks.id','=','inputtaks.tak_id') 
        ->where('mahasiswas.id',$mahasiswa)
        ->where('notif_tak_masuks.notif_tak_read','1')
        ->sum('taks.tak_score');
        return view('mahasiswa.index',compact('score'));
    }
    public function notif(){
        $mahasiswa = Auth::user()->mahasiswa->id;
        $notif= DB::table('notif_tak_masuks')
            ->join('mahasiswas','mahasiswas.id','=','notif_tak_masuks.mahasiswa_id')
            ->join('dosens','dosens.id','=','notif_tak_masuks.dosen_id')
            ->join('inputtaks','inputtaks.id','=','notif_tak_masuks.inputtak_id')
            ->select('notif_tak_masuks.id','notif_tak_masuks.updated_at','dosens.dosen_nama','dosens.dosen_image')
            ->where('mahasiswas.id',$mahasiswa)
            ->where('notif_tak_masuks.notif_tak_read','0')
            ->get();
        $jumlah = $notif->count();
        $total_tak = DB::table('notif_tak_masuks')
        ->join('mahasiswas','mahasiswas.id','=','notif_tak_masuks.mahasiswa_id')
        ->join('inputtaks','inputtaks.id','=','notif_tak_masuks.inputtak_id')
        ->join('taks','taks.id','=','inputtaks.tak_id') 
        ->where('mahasiswas.id',$mahasiswa)
        ->where('notif_tak_masuks.notif_tak_read','1')
        ->sum('taks.tak_score');
        $mhs = Mahasiswa::find($mahasiswa);
        $tutorial_status = $mhs->mahasiswa_tutorial_status;
        $tutorial = DB::table('tutorials')->where('mahasiswa_id',$mahasiswa)
        ->where('tutorial_status','0')
        ->first();
        $mhs_get_badge = $mhs->badge_id;
        $mhs_badge = Badge::where('id',$mhs_get_badge)->first();
        $mhs_badge_nama= $mhs_badge->badge_nama;
        $angkatan = $mhs->angkatan_id;
        $prodi = $mhs->prodi_id;
        $tak_kumulatif = DB::table('takkumulatifs')->where('angkatan_id',$angkatan)->where('prodi_id',$prodi)->first();
        $poinGold = $tak_kumulatif->poinminimum;
        $poinBronze = $poinGold/3;
        $poinSilver = $poinBronze *2;
        $score = (int)$total_tak;
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
            $next_badge='no';
            $get_badge='no';
        }
       if($tutorial){
           if($jumlah!=0){
            return response()->json(['get_badge'=>$get_badge,'next_badge'=>$next_badge,'notif'=>$notif,'jumlah'=>$jumlah,'score'=>$score,'tutorial'=>$tutorial,'tutorial_status'=>$tutorial_status,'jumlah_tutorial'=>1]);
           } else{
            return response()->json(['get_badge'=>$get_badge,'next_badge'=>$next_badge,'notif'=>$notif,'jumlah'=>$jumlah,'score'=>$score,'tutorial'=>$tutorial,'tutorial_status'=>$tutorial_status,'jumlah_tutorial'=>1]);
           }
        
       } else{
        return response()->json(['notif'=>$notif,'jumlah'=>$jumlah,'score'=>$score]);
       }      
    }
    public function DaftarMenu(){
        $mahasiswa = Auth::user()->mahasiswa->id;
        $mhs = Mahasiswa::find($mahasiswa);
        $angkatan = $mhs->angkatan_id;
        $prodi = $mhs->prodi_id;
        $tak = DB::table('takkumulatifs')->where('angkatan_id',$angkatan)->where('prodi_id',$prodi)->first();
        $poinminim = $tak->poinminimum;
        $score = DB::table('notif_tak_masuks')
        ->join('mahasiswas','mahasiswas.id','=','notif_tak_masuks.mahasiswa_id')
        ->join('inputtaks','inputtaks.id','=','notif_tak_masuks.inputtak_id')
        ->join('taks','taks.id','=','inputtaks.tak_id') 
        ->where('mahasiswas.id',$mahasiswa)
        ->where('notif_tak_masuks.notif_tak_read','1')
        ->sum('taks.tak_score');
        $intPoint = (int)$poinminim;
        $intScore = (int)$score;
        $tutorial_status = $mhs->mahasiswa_tutorial_status;
        $tutorial = DB::table('tutorials')->where('mahasiswa_id',$mahasiswa)->first();
        if($tutorial){
            if($intScore >= $intPoint){
                return response()->json(['mahasiswa'=>$mhs,'tutorial_status'=>$tutorial_status,'validasi'=>'yes','tutorial'=>'yes','poinminim'=>$intPoint,'score'=>$intScore]);
            } else{
                return response()->json(['mahasiswa'=>$mhs,'tutorial_status'=>$tutorial_status,'tutorial'=>'yes','validasi'=>'no','poinminim'=>$intPoint,'score'=>$intScore]);
            }
            
        } else{
            return response()->json(['mahasiswa'=>$mhs,'tutorial_status'=>$tutorial_status,'tutorial'=>'no','poinminim'=>$intPoint,'score'=>$intScore]);
        }
       
    }
    public function getBadge(){
        
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
        
        $mhs_badge_nama= $badge->badge_nama;
        $score =(int)$total_tak;
        if($score < $poinBronze){
            $next_badge= Badge::where('badge_nama','bronze')->first();
            $next_badge_image = $next_badge->badge_image;
            $next_badge_nama = 'Bronze';
            $next_badge_point = $poinBronze - $score;
            $progress = ($next_badge_point/$poinBronze) *100;
            $next_badge_max_point = 100 - $progress;
            
        }
        elseif($score >= $poinBronze && $score <$poinSilver){
            $next_badge= Badge::where('badge_nama','silver')->first();
            $next_badge_image = $next_badge->badge_image;
            $next_badge_nama = 'Silver';
            $next_badge_point = $poinSilver - $score;
            $progress = ($next_badge_point/$poinSilver) *100;
            $next_badge_max_point = 100 - $progress;
        }elseif($score >= $poinSilver && $score <$poinGold){
            $next_badge= Badge::where('badge_nama','gold')->first();
            $next_badge_image = $next_badge->badge_image;
            $next_badge_nama = 'Gold';
            $next_badge_point = $poinGold - $score;
            $progress = ($next_badge_point/$poinGold) *100;
            $next_badge_max_point = 100 - $progress;
        } else{
            $next_badge= Badge::where('badge_nama','gold')->first();
            $next_badge_image = $next_badge->badge_image;
            $next_badge_nama = 'Selesai';
            $next_badge_point = 'Selesai';
            $next_badge_max_point = 100;
        }  
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

        return response()->json(['get_badge'=>$get_badge,'badge_image'=>$badge_image,'score'=>$score,'next_badge_max_point'=>$next_badge_max_point,'next_badge_point'=>$next_badge_point,'next_badge_nama'=>$next_badge_nama,'next_badge_image'=>$next_badge_image]);
        
    }
    public function badgeTutorial()
    {
        $badge =Badge::where('badge_nama','tutorial')->first();
        
        return response()->json($badge);
    }
    public function DetailNotif($id){
        $notif = NotifTakMasuk::find($id);
        $kegiatantak = $notif->inputtak->tak->kegiatantak->kegiatantak_nama;
        $partisipasitak = $notif->inputtak->tak->partisipasitak->partisipasitak_nama;
        $skor = $notif->inputtak->tak->tak_score;
        return response()->json(['notif'=>$notif,'skor'=>$skor,'partisipasitak'=>$partisipasitak,'kegiatantak'=>$kegiatantak]);
   
    }
    public function DetailTutorial($id){
        $tutorial = Tutorial::find($id);
        $kegiatantak = $tutorial->tak->kegiatantak->kegiatantak_nama;
        $partisipasitak = $tutorial->tak->partisipasitak->partisipasitak_nama;
        $skor = $tutorial->tak->tak_score;
        return response()->json(['tutorial'=>$tutorial,'skor'=>$skor,'partisipasitak'=>$partisipasitak,'kegiatantak'=>$kegiatantak]);
   
    }
    public function ReadNotif($id){
        $notif = NotifTakMasuk::findOrFail($id);
        $notif->notif_tak_read = '1';
        $notif->save();
        return response()->json();
    }
    public function ReadTutorial($id){
        $mahasiswa = Auth::user()->mahasiswa->id;
        $mhs = Mahasiswa::find($mahasiswa);
        $badge =Badge::where('badge_nama','tutorial')->first();
        $badge_id = $badge->id;
        $mhs->badge_id = $badge_id;
        $mhs->mahasiswa_tutorial_status = '1';
        $mhs->save();
        return response()->json();
    }
    public function changeBadge($id){
        $badge = Badge::find($id);
        $badge_id = $badge->id;
        $mahasiswa= Auth::user()->mahasiswa->id;
        $mhs = Mahasiswa::find($mahasiswa);
        $mhs->badge_id = $badge_id;
        $mhs->save();
        return response()->json();
    }
}
