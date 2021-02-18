<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategoritak extends Model
{
       
    protected $primaryKey = 'id';
    protected $fillable = ['kategoritak_nama'];
}
