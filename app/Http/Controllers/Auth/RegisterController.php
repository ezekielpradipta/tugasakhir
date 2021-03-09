<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Prodi;
use App\Models\Dosen;
use App\Mahasiswa;
use Illuminate\Support\Str;
use App\Models\Angkatan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
class RegisterController extends Controller
{
    public function register(){
        $prodis = Prodi::orderBy('prodi_nama', 'ASC')->get();
        $dosens = Dosen::orderBy('dosen_nama', 'ASC')->get();
        $angkatans = Angkatan::orderBy('angkatan_tahun', 'ASC')->get();
    	return view('auth.register',compact('prodis','angkatans','dosens'));
    }
    public function daftar(Request $request){
        $this->validate($request,[
            'nama' => ['required', 'string', 'max:255','unique:mahasiswas,nama'],
            'email' => ['required', 'string', 'regex:/st3telkom\.ac\.id|ittelkom-pwt\.ac\.id]/', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8','same:password_confirmation'],
            'image'=>['nullable','image','max:2048'],
            'angkatan_id'=>['required'],
            'prodi_id'=>['required'],
            'dosen_id'=>['required'],
        ]);
            $email = $request->email;
            $data =$request->all();
            $data['nim']= Str::substr($email, 0,8);
            $data['role']= User::USER_ROLE_MHS;
            $data['status']= User::USER_IS_ACTIVE;
            $data['password'] = bcrypt($request->password);
            $data['password_text'] = $request->password;
            $data['username']= $request->username;
            $data['nama']= $request->nama;
          
            $data['slugImage']=$request->nama;
            if ($request->image) {
                $file = $request->file('image');
                $filename = Str::slug($request->nama) . '.' . $file->getClientOriginalExtension();
                $data['image']= $request->image->storeAs('mahasiswa',$filename,'images');
            } else {
               
                     $data['image']= Mahasiswa::USER_PHOTO_DEFAULT;
            }
        $user = User::create($data);
              if ($user) {
                    $user->mahasiswa()->create($data);
                    $user->mahasiswa->save();
                    return redirect()->route('login')->with('success', 'Akun berhasil disimpan dan akan dilakukan validasi dan konfirmasi');
                 } else{
                    return redirect()->route('login')->with('fail', 'Gagal Mendaftar');
                }

    }
    public function cekEmail(Request $request){
    	if($request->get('email')){
    		$email = $request->get('email');
    		$data =DB::table("users")->where('email',$email)->count();
    			if($data >0){
    				echo "not_unique";
    			} else {
    				echo "unique";
    			}
    	}
    }
    public function cekUsername(Request $request){
    	if($request->get('username')){
    		$username = $request->get('username');
    		$data =DB::table("users")->where('username',$username)->count();
    			if($data >0){
    				echo "not_unique";
    			} else {
    				echo "unique";
    			}
    	}
    }
    public function cekUsernameRegister(Request $request){
        if($request->get('username1')){
            $username = $request->get('username1');
            $data =DB::table("users")->where('username',$username)->count();
                if($data >0){
                    echo "not_unique";
                } else {
                    echo "unique";
                }
        }
    }    

}
