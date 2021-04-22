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
}
