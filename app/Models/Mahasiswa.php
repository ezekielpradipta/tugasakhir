<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class Mahasiswa extends Model
{
    protected $primaryKey = 'id';
    protected $fillable=['user_id','dosen_id','prodi_id','angkatan_id','mahasiswa_nama','mahasiswa_nim','mahasiswa_image'];
    const USER_PHOTO_URL = '/img';
	const USER_PHOTO_DEFAULT ='user.png';
    public function dosen(){
    	return $this->belongsTo(Dosen::class);
    }
    public function user(){
    	return $this->belongsTo(User::class);
    }
    public function prodi(){
    	return $this->belongsTo(Prodi::class);
    }
    public function angkatan(){
    	return $this->belongsTo(Angkatan::class);
    }
    public function getimageURLAttribute()
    {
        return asset($this::USER_PHOTO_URL).'/'.$this->mahasiswa_image;
    }
    public function deleteImage()
    {
        if($this->mahasiswa_image!=$this::USER_PHOTO_DEFAULT)
        {
            return Storage::disk('images')->delete($this->mahasiswa_image);
        }
        return TRUE;
    }
}
