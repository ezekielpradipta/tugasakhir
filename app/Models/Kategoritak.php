<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategoritak extends Model
{
       
    protected $primaryKey = 'id';
    protected $fillable = ['kategoritak_nama'];
    public function pilartak(){
        return $this->hasMany(Pilartak::class);
    }
    public function tak(){
        return $this->hasMany(Tak::class);
    }
}
