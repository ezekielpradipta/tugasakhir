<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class Dosen extends Model
{
    const USER_PHOTO_URL = '/img';
	const USER_PHOTO_DEFAULT ='user.png';
	protected $primaryKey = 'id';
	protected $fillable =['nidn','user_id','dosen_image','dosen_status','dosen_nama'];


	public function getimageURLAttribute()
    {
        return asset($this::USER_PHOTO_URL).'/'.$this->dosen_image;
    }
    public function mahasiswa(){
        return $this->hasMany(Mahasiswa::class);
    }
    public function user(){
    	return $this->belongsTo(User::class);
    }
    public function notiftakmasuk(){
        return $this->hasMany(NotifTakMasuk::class);
    }
    public function deleteImage()
    {
        if($this->dosen_image!=$this::USER_PHOTO_DEFAULT)
        {
            return Storage::disk('images')->delete($this->dosen_image);
        }
        return TRUE;
    }
    
}
