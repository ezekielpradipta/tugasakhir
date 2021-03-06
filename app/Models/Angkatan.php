<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Angkatan extends Model
{
    protected $primaryKey = 'id';
     protected $fillable = ['angkatan_tahun'];
     public function takkumulatif(){
        return $this->hasMany(Takkumulatif::class);
    }
}
