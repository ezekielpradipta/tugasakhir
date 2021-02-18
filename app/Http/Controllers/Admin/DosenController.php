<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Response;
use File;
use Storage;
class DosenController extends Controller
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
    public function cekNIDN(Request $request){
    	if($request->get('nidn')){
    		$nidn = $request->get('nidn');
    		$data =DB::table("dosens")->where('nidn',$nidn)->count();
    			if($data >0){
    				echo "not_unique";
    			} else {
    				echo "unique";
    			}
    	}
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $dosen =Dosen::with('user')->latest()->get();
            return Datatables::of($dosen)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editItem"><span class="fa fa-pencil"></a>';
                            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteItem"><span class="fa fa-trash"></a>';
                            return $btn;
                    })
                    ->editColumn('nama',function($dosen){
                        return '<img style="height: 50px; width: 80px; margin-right: 10px;" src="'.$dosen->image_url.'" />'
                                .$dosen->dosen_nama;
                    })
                    ->rawColumns(['action','nama'])
                    ->make(true);

        }

        return view('admin.dosen.index');
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
            'dosen_nama'=>['required','min:3'],
            'password' => ['required', 'string', 'min:8','same:password_confirmation'],
            'dosen_image'=>['nullable','image','max:2048'],
        ]);
          $data = request()->except(['_token']);
          $data['dosen_id']= $request->dosen_id;
          $data['role']= User::USER_ROLE_DOSEN;
          $data['status']= User::USER_IS_ACTIVE;
          $data['password'] = bcrypt($request->password);
          $data['password_text'] = $request->password;
          $data['username']= $request->username;
          $data['dosen_nama']= $request->dosen_nama;
          $data['nidn']=$request->nidn;
          

          if ($request->file('dosen_image')) {
              
              
              $imagePath = $request->file('dosen_image');
              $imageName = date('YmdHis').'.' . $imagePath->getClientOriginalName();
              $path = $request->file('dosen_image')->storeAs('dosen', $imageName, 'images');
              $data['dosen_image']=$path;
          } else{
            $data['dosen_image']=Dosen::USER_PHOTO_DEFAULT;
          }
        
          $user = User::create($data);
          $user->dosen()->create($data);
          $user->dosen->save();
          return response()->json();
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function show(Dosen $dosen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $dosen = DB::table("dosens")->join ('users','users.id','=','dosens.user_id')
        ->where('dosens.id',$id)->get();
        return response()->json($dosen);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function updateDong(Request $request, Dosen $dosen)
    {
        $this->validate($request,[
            'dosen_nama'=>['required','min:3'],
            'password' => ['required', 'string', 'min:8','same:password_confirmation'],
            'dosen_image'=>['nullable','image','max:2048'],
        ]);
        $dosen = Dosen::where('id',$request->dosen_id)->first();
        $user = User::where('id',$request->user_id)->first();
                    $item = request()->except(['_token','dosen_image','email','password','nidn','password_text','dosen_nama','username']);
                    if ($request->file('dosen_image')) {
                        
                            $dosen->deleteImage();
                            $imagePath = $request->file('dosen_image');
                            $imageName = date('YmdH') . '.' . $imagePath->getClientOriginalName();
                            $path = $request->file('dosen_image')->storeAs('dosen', $imageName, 'images');
                            $item['dosen_image']=$path;
                    }
                    if($request->password)
                    {
                        $item['password'] = bcrypt($request->password);
                        $item['password_text'] = $request->password;
                    }
            
                    $item['dosen_nama']= $request->dosen_nama;
                    if($request->username){
                        $datauser['username']=$request->username;
                        $user->update($datauser);
                        $user->save();
                    }
                    if($request->nidn){
                        $datauser['nidn']=$request->nidn;
                        $user->update($datauser);
                        $user->save();
                    }
                    if($request->email){
                        $datauser['email']=$request->email;
                        $user->update($datauser);
                        $user->save();
                    }
                    $dosen->update($item);    
                    $dosen->save();
                    return response()->json([$dosen,$user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dosen $dosen)
    {
        
        //$data = Dosen::where('id',$id)->first(['dosen_image']);
        //\File::delete('public/img/'.$data->dosen_image);
        $dosen->deleteImage();
        $dosen->user()->delete();
        return response()->json($dosen);
    }
}
