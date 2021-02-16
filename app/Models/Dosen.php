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
	protected $fillable =['nidn','user_id','imageDosen','namaDosen','slugImageDosen'];


	public function getimageURLAttribute()
    {
        return asset($this::USER_PHOTO_URL).'/'.$this->imageDosen;
    }
    public function setSlugAttribute($value)
    {
        $this->attributes['slugImageDosen'] = Str::slug($value); 
    }
    public function user(){
    	return $this->belongsTo(User::class);
    }
   
    public function deleteImage()
    {
        if($this->imageDosen!=$this::USER_PHOTO_DEFAULT)
        {
            return Storage::disk('images')->delete($this->imageDosen);
        }
        return TRUE;
    }
    
}
