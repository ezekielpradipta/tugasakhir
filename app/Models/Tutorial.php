<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tutorial extends Model
{
    protected $fillable = ['mahasiswa_id','tak_id','tutorial_bukti','tutorial_tanggalakhir','tutorial_deskripsi','tutorial_tanggalawal','tutorial_namaindo','tutorial_namainggris','tutorial_status','tutorial_tahunajaran','tutorial_penyelenggara'];
    public function mahasiswa(){
    	return $this->belongsTo(Mahasiswa::class);
    }
    public function tak(){
    	return $this->belongsTo(Tak::class);
    }
}
