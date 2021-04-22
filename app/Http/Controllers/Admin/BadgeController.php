<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Storage;
class BadgeController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $badge = Badge::latest()->get();
            return Datatables::of($badge)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm btn-edit"><span class="fa fa-pencil"></a>';
                            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm btn-delete"><span class="fa fa-trash"></a>';
                            return $btn;
                    })
                    ->editColumn('nama',function($badge){
                        return '<img style="height: 50px; width: 80px; margin-right: 10px;" src="'.$badge->image_url.'" />'
                                .$badge->badge_nama;
                    })
                    ->rawColumns(['nama','action'])
                    ->make(true);
        }
        return view('admin.badge.index');
    }
    public function store(Request $request){
        if ($request->file('badge_image')) {
            Storage::disk('images')->delete($request->hidden_image);
            $imagePath = $request->file('badge_image');
            $imageName = date('YmdHis').'-' . $imagePath->getClientOriginalName();
            $path = $request->file('badge_image')->storeAs('badge', $imageName, 'images');
            $badge_image=$path;
        } else{
            $badge_image=$request->hidden_image;
        }
        $badge =Badge::updateOrCreate(['id' => $request->badge_id],
        ['badge_nama' => $request->badge_nama,
        'badge_image' => $badge_image,
        
        ]);
        return response()->json();   

    }
    public function edit($id){
        $badge = Badge::find($id);
        return response()->json($badge);
    }
    public function destroy($id){
        $badge = Badge::find($id);
        $badge_image = $badge->badge_image;
        Storage::disk('images')->delete($badge_image);
        $badge->delete();
        return response()->json();
    }
}
