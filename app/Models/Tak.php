<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tak extends Model
{
    protected $fillable = ['kegiatantak_id', 'tak_score','kategoritak_id','pilartak_id','partisipasitak_id'];
        public function kegiatantak()
    {
        return $this->belongsTo(Kegiatantak::class);
    }
    public function kategoritak()
    {
        return $this->belongsTo(Kategoritak::class);
    }
    public function pilartak()
    {
        return $this->belongsTo(Pilartak::class);
    }
    public function partisipasitak()
    {
        return $this->belongsTo(Partisipasitak::class);
    }
}
