<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Support\Str;
use \Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
class ProfileController extends Controller
{
    public function index()
    {
        return view('mahasiswa.profile');
    }
    public function getData(){
        $mahasiswa_id = Auth::user()->mahasiswa->id;
        $user_id = Auth::user()->id;
        $mahasiswa = Mahasiswa::find($mahasiswa_id);
        $user = User::find($user_id);
        return response()->json(['mahasiswa'=>$mahasiswa,'user'=>$user]);
    }
    public function store(Request $request){
        $this->validate($request,[
            'mahasiswa_nama'=>['required','min:3'],
            'mahasiswa_nim'=>['required','min:8','max:8'],
            'password' => ['required', 'string', 'min:8','same:password_confirmation'],
        ]);
        $mahasiswa_id = Auth::user()->mahasiswa->id;
        $user_id = Auth::user()->id;
            if ($request->file('mahasiswa_image')) {
                if($request->hidden_image!=Mahasiswa::USER_PHOTO_DEFAULT){
                    Storage::disk('images')->delete($request->hidden_image);
                }
                $imagePath = $request->file('mahasiswa_image');
                $imageName = date('YmdHis').'-' .Str::slug($request->mahasiswa_nama).'-' . $imagePath->getClientOriginalName();
                $path = $request->file('mahasiswa_image')->storeAs('mahasiswa', $imageName, 'images');
                $image=$path;
            } else{
                $image=$request->hidden_image;
            }
            $user = User::where('id',$user_id)->update([
                'email' => $request->email,
                'username' => $request->username,
                'password'=>bcrypt($request->password),
                'password_text'=>$request->password,
            ]);
            $mahasiswa = Mahasiswa::where('id',$mahasiswa_id)->update([
                'mahasiswa_image' => $image,
                'mahasiswa_nama'=>$request->mahasiswa_nama,
                'mahasiswa_nim'=>$request->mahasiswa_nim,
            ]);
            return response()->json();
        
        
    }
}
