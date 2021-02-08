<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
class User extends Authenticatable
{
    use Notifiable;
    const USER_ROLE_ADMIN = 'admin';
    const USER_ROLE_MHS = 'mhs';
    const USER_ROLE_DOSEN ='dosen';
    const USER_ROLE_KMS ='kemahasiswaan';
    const USER_IS_ACTIVE = '1';
    const USER_IS_NOT_ACTIVE ='0';
    
    public function dosen(){
        return $this->hasOne(Dosen::class);
    }
    public function mahasiswa(){
        return $this->hasOne(Mahasiswa::class);
    }
    public function admin(){
        return $this->hasOne(Admin::class);
    }
    public function kemahasiswaan(){
        return $this->hasOne(Kemahasiswaan::class);
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',  'email', 'password', 'role', 'status','password_text'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
}
