<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inputtak extends Model
{
    const TAK_DIACC = 1;
    const TAK_BLUM_DIACC = 0;
    
    protected $fillable = ['mahasiswa_id','tak_id','inputtak_bukti','inputtak_tanggalakhir','inputtak_deskripsi','inputtak_tanggalawal','inputtak_namaindo','inputtak_namainggris','inputtak_status','inputtak_tahunajaran','inputtak_penyelenggara'];
    public function mahasiswa(){
    	return $this->belongsTo(Mahasiswa::class);
    }
    public function tak(){
    	return $this->belongsTo(Tak::class);
    }
    
}
