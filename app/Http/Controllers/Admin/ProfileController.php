<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use \Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
class ProfileController extends Controller
{
    public function index(){
        $admin_id = Auth::user()->admin->id;
        
        return view('admin.profile.index');
    }
    public function getData(){
        $admin_id = Auth::user()->admin->id;
        $user_id = Auth::user()->id;
        $admin = Admin::find($admin_id);
        $user = User::find($user_id);
        return response()->json(['admin'=>$admin,'user'=>$user]);
    }
    public function store(Request $request){
        $this->validate($request,[
            'password' => ['required', 'string', 'min:8','same:password_confirmation'],
        ]);
        $admin_id = Auth::user()->admin->id;
        $user_id = Auth::user()->id;
            if ($request->file('admin_image')) {
                if($request->hidden_image!=Admin::USER_PHOTO_DEFAULT){
                    Storage::disk('images')->delete($request->hidden_image);
                }
                $imagePath = $request->file('admin_image');
                $imageName = date('YmdHis').'-' . $imagePath->getClientOriginalName();
                $path = $request->file('admin_image')->storeAs('admin', $imageName, 'images');
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
            $admin = Admin::where('id',$admin_id)->update([
                'admin_image' => $image,
                'admin_nama'=>$request->admin_nama,
            ]);
            return response()->json();
        
        
    }
}
