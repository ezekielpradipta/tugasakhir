<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dosen;
use App\Models\User;
use \Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
class ProfileController extends Controller
{
    public function index(){
        return view('dosen.profile.index');
    }
    public function getData(){
        $dosen_id = Auth::user()->dosen->id;
        $user_id = Auth::user()->id;
        $dosen = Dosen::find($dosen_id);
        $user = User::find($user_id);
        return response()->json(['dosen'=>$dosen,'user'=>$user]);
    }
    public function store(Request $request){
        $this->validate($request,[
            'dosen_nama'=>['required','min:3'],
            'nidn'=>['required',],
            'password' => ['required', 'string', 'min:8','same:password_confirmation'],
        ]);
        $dosen_id = Auth::user()->dosen->id;
        $user_id = Auth::user()->id;
            if ($request->file('dosen_image')) {
                if($request->hidden_image!=Dosen::USER_PHOTO_DEFAULT){
                    Storage::disk('images')->delete($request->hidden_image);
                }
                $imagePath = $request->file('dosen_image');
                $imageName = date('YmdHis').'-' . $imagePath->getClientOriginalName();
                $path = $request->file('dosen_image')->storeAs('dosen', $imageName, 'images');
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
            $dosen = Dosen::where('id',$dosen_id)->update([
                'dosen_image' => $image,
                'dosen_nama'=>$request->dosen_nama,
                'dosen_status'=>Auth::user()->dosen->dosen_status,
            ]);
            return response()->json();
        
        
    }
}
