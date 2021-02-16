<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class Admin extends Model
{
    const USER_PHOTO_URL = '/img';
	const USER_PHOTO_DEFAULT ='user.png';
	protected $primaryKey = 'id';
	protected $fillable =['nidn','user_id','image','namaAdmin'];


	public function getimageURLAttribute()
    {
        return asset($this::USER_PHOTO_URL).'/'.$this->image;
    }
    
    public function user(){
    	return $this->belongsTo(User::class);
    }
    public function deleteimage()
    {
        if($this->image!=$this::USER_PHOTO_DEFAULT)
        {
            return Storage::disk('images')->delete($this->image);
        }
        return TRUE;
    }
}
