<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pilartak extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = ['kategoritak_id', 'pilartak_nama'];
    public function kategoritak(){
    	return $this->belongsTo(Kategoritak::class);
    }
    public function kegiatantak(){
        return $this->hasMany(Kegiatantak::class);
    }
    public function tak(){
        return $this->hasMany(Tak::class);
    }
}
