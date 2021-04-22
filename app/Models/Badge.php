<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    const USER_PHOTO_URL = '/img';
    protected $primaryKey = 'id';
    protected $fillable = ['badge_image','badge_nama'];
    public function getimageURLAttribute()
    {
        return asset($this::USER_PHOTO_URL).'/'.$this->badge_image;
    }
    public function user(){
    	return $this->belongsTo(Mahasiswa::class);
    }
}
