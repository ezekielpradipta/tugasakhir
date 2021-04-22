<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    protected $primaryKey = 'id';
     protected $fillable = ['prodi_nama'];
     public function takkumulatif(){
        return $this->hasMany(Takkumulatif::class);
    }
}
