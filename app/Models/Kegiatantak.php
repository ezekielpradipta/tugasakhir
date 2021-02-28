<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatantak extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = ['pilartak_id', 'kegiatantak_nama'];
    public function pilartak(){
    	return $this->belongsTo(Pilartak::class);
    }
    public function partisipasitak(){
        return $this->hasMany(Partisipasitak::class);
    }
    public function tak(){
        return $this->hasMany(Tak::class);
    }
}
