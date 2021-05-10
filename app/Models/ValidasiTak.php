<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValidasiTak extends Model
{
    protected $primaryKey = 'id';
    protected $fillable=['mahasiswa_id','dosen_id','validasi_status'];
    public function mahasiswa(){
    	return $this->belongsTo(Mahasiswa::class);
    }
    public function dosen(){
    	return $this->belongsTo(Dosen::class);
    }
}
