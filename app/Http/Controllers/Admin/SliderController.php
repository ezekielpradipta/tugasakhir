<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Response;
use File;
use Storage;
class SliderController extends Controller
{
    public function index(Request $request){
        if($request->ajax()){
            $jenis = $request->jenis;
            $slider = DB::table('sliders')
            ->orderBy('slider_order','asc')
            ->where('slider_jenis',$jenis)
            ->get();
            return Datatables::of($slider)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm btn-edit"><span class="fa fa-pencil"></a>';
                            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm btn-delete"><span class="fa fa-trash"></a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.slider.index');
    }
    
    public function slider_tambah(Request $request){
        
            if ($request->file('slider_image')) {
                Storage::disk('images')->delete($request->hidden_image);
                $imagePath = $request->file('slider_image');
                $imageName = date('YmdHis').'-' . $imagePath->getClientOriginalName();
                $path = $request->file('slider_image')->storeAs('slider', $imageName, 'images');
                $slider_image=$path;
            } else{
                $slider_image=$request->hidden_image;
            }
            $slider =Slider::updateOrCreate(['id' => $request->slider_id],
            [
                'slider_caption' => $request->slider_caption,
                'slider_image' => $slider_image,
                'slider_order' => $request->slider_order,
                'slider_jenis'=> $request->slider_jenis,
            
            ]
            );
         
         return response()->json();
    }
    public function slider_edit($id){
        $slider = Slider::find($id);
        return response()->json($slider);
    }
    public function slider_delete($id){
        $slider = Slider::find($id);
        $slider_image = $slider->slider_image;
        Storage::disk('images')->delete($slider_image);
        $slider->delete();
        return response()->json();
    }
}
