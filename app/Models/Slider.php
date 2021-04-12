<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class Slider extends Model
{
    const USER_PHOTO_URL = '/img';
    protected $primaryKey = 'id';
	protected $fillable =['slider_caption','slider_image','slider_order','slider_jenis'];
    

}
