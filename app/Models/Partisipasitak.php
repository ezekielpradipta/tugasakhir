<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partisipasitak extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = ['kegiatantak_id','tingkattak_id', 'partisipasitak_nama'];
    
    public function kegiatantak(){
    	return $this->belongsTo(Kegiatantak::class);
    }
    public function tak(){
        return $this->hasMany(Tak::class);
    }
}
