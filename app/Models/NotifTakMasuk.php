<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifTakMasuk extends Model
{
    
    protected $fillable = ['inputtak_id','mahasiswa_id', 'dosen_id'];
   
    public function inputtak(){
    	return $this->belongsTo(Inputtak::class);
    }
    public function mahasiswa(){
    	return $this->belongsTo(Mahasiswa::class);
    }
    public function dosen(){
    	return $this->belongsTo(Dosen::class);
    }
}
