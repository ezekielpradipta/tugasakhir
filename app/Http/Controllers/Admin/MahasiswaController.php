<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Angkatan;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Response;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Storage;
class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
    public function cekDosen(){
        $dosen =Dosen::pluck('dosen_nama','id');
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
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $mahasiswa =Mahasiswa::with('user')->latest()->get();
            return Datatables::of($mahasiswa)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editItem"><span class="fa fa-pencil"></a>';
                            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteItem"><span class="fa fa-trash"></a>';
                            return $btn;
                    })
                    ->editColumn('nama',function($mahasiswa){
                        return '<img style="height: 50px; width: 80px; margin-right: 10px;" src="'.$mahasiswa->image_url.'" />'
                                .$mahasiswa->mahasiswa_nama;
                    })
                    ->rawColumns(['action','nama'])
                    ->make(true);

        }
        return view('admin.mahasiswa.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'mahasiswa_nama'=>['required','min:3'],
            'password' => ['required', 'string', 'min:8','same:password_confirmation'],
            'mahasiswa_image'=>['nullable','image','max:2048'],

        ]);
        $user =User::updateOrCreate(['id' => $request->user_id],
                [
                    'email' => $request->email,
                    'username' => $request->username,
                    'role'=> User::USER_ROLE_MHS,
                    'status'=>User::USER_IS_ACTIVE,
                    'password'=>bcrypt($request->password),
                    'password_text'=>$request->password,
                ]
        );
        
        if ($request->mahasiswa_id){
            if ($request->file('mahasiswa_image')) {
                if($request->hidden_image!=Mahasiswa::USER_PHOTO_DEFAULT){
                    Storage::disk('images')->delete($request->hidden_image);
                }
                $imagePath = $request->file('mahasiswa_image');
                $imageName = date('YmdHis').'-'.Str::slug($request->mahasiswa_nama).'-' . $imagePath->getClientOriginalName();
                $path = $request->file('mahasiswa_image')->storeAs('mahasiswa', $imageName, 'images');
                $mahasiswa_image=$path;
            }
            else{
                $mahasiswa_image= $request->hidden_image;
            }
        }
        else{
            if ($request->file('mahasiswa_image')) {
                $imagePath = $request->file('mahasiswa_image');
                $imageName = date('YmdHis').'-'.Str::slug($request->mahasiswa_nama).'-' . $imagePath->getClientOriginalName();
                $path = $request->file('mahasiswa_image')->storeAs('mahasiswa', $imageName, 'images');
                $mahasiswa_image=$path;
            }
            else {
                $mahasiswa_image= Mahasiswa::USER_PHOTO_DEFAULT;
            }
        }
         
        $email=$request->email;
        $mahasiswa_nim= Str::substr($email, 0,8);
        
        $user->mahasiswa()->updateOrCreate(['user_id' => $user->id,'dosen_id'=>$request->dosen_val,'prodi_id'=>$request->prodi_val,'angkatan_id'=>$request->angkatan_val], 
        [
            'mahasiswa_nama' =>$request->mahasiswa_nama,
            'mahasiswa_nim' =>$mahasiswa_nim,
            'mahasiswa_image' =>$mahasiswa_image,

        ]);

        return response()->json();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function show(Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mahasiswa = Mahasiswa::with('user')->find($id);
        return response()->json($mahasiswa);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->deleteImage();
        $mahasiswa->user()->delete();
        return response()->json($mahasiswa);
    }
}
