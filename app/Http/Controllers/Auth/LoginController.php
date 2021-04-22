<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Prodi;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Angkatan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
class LoginController extends Controller
{
    public function login(){
        return view('auth.login');
    }
       public function ceklogin(Request $request){
    	$this->validate($request,[
    	'username' => ['required', 'string'],
    	'password' => ['required','string', 'min:6'],
    	]);
    	//bisa login via email/ username
    	$loginType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

    	$login =[
    		$loginType => $request->username,
    		'password' => $request->password
    	];
    	
    	if (Auth::attempt($login)){
    		return redirect()->route('dashboard');
    	}
    	return redirect()->route('login')->with(['fail'=>'Email atau password yang dimasukan salah']);
	}
	    public function logout(){
        Auth::logout();
        Session::flush();
        

        alert()->success('Anda Telah Berhasil LogOut', 'Good bye!');

        return redirect('/');
    }
    public function cekRole(){
        if (Auth::user()->role==User::USER_ROLE_ADMIN){
            return redirect()->route('admin.dashboard.index');
        } else if (Auth::user()->role==User::USER_ROLE_MHS) {
            return redirect()->route('mahasiswa.index');
        }else if (Auth::user()->role==User::USER_ROLE_DOSEN) {
            return redirect()->route('dosen.dashboard.index');
        }
        else{
            abort(404, 'not found');
        }
    }
    public function cekEmail(Request $request){
    	if($request->get('email_register')){
    		$email_register = $request->get('email_register');
    		$data =DB::table("users")->where('email',$email_register)->count();
    			if($data >0){
    				echo "not_unique";
    			} else {
    				echo "unique";
    			}
    	}
    }
    public function cekUsername(Request $request){
    	if($request->get('username_register')){
    		$username_register = $request->get('username_register');
    		$data =DB::table("users")->where('username',$username_register)->count();
    			if($data >0){
    				echo "not_unique";
    			} else {
    				echo "unique";
    			}
    	}
    }
    public function cekDosen(){
        $dosen =Dosen::where('dosen_status','dosenwali')->pluck('dosen_nama','id');
        return json_encode($dosen);
    }
    public function cekAngkatan(){
        $angkatan =Angkatan::pluck('angkatan_tahun','id');
        return json_encode($angkatan);
    }
    public function cekProdi(){
        $prodi =Prodi::pluck('prodi_nama','id');
        return json_encode($prodi);
    }
    public function daftar(Request $request){
        $this->validate($request,[
            'mahasiswa_nama'=>['required','min:3'],
            'password_register' => ['required', 'string', 'min:8','same:password_confirmation'],
            'mahasiswa_image'=>['nullable','image','max:2048'],

        ]);
        DB::beginTransaction();
        try {
            $email = $request->email_register;
            $data['mahasiswa_nim']= Str::substr($email, 0,8);
            $data['email']= $request->email_register;
            $data['role']= User::USER_ROLE_MHS;
            $data['status']= User::USER_IS_ACTIVE;
            $data['password'] = bcrypt($request->password_register);
            $data['password_text'] = $request->password_register;
            $data['username']= $request->username_register;
            $data['mahasiswa_nama']= $request->mahasiswa_nama;
            $data['dosen_id']= $request->dosen_id;
            $data['angkatan_id']= $request->angkatan_id;
            $data['prodi_id']= $request->prodi_id;
            if ($request->file('mahasiswa_image')) {
                $imagePath = $request->file('mahasiswa_image');
                $imageName = date('YmdHis').'-'.Str::slug($request->mahasiswa_nama).'-' . $imagePath->getClientOriginalName();
                $path = $request->file('mahasiswa_image')->storeAs('mahasiswa', $imageName, 'images');
                $data['mahasiswa_image']=$path;
            }
            else {
                $data['mahasiswa_image']= Mahasiswa::USER_PHOTO_DEFAULT;
            }
    
            $user = User::create($data);
            if($user){
                $user->mahasiswa()->create($data);
                $user->mahasiswa->save();
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
        
        return response()->json();
    }
}
