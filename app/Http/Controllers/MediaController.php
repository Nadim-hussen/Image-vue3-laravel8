<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;
class MediaController extends Controller
{
    public function getImg(){
        $data = Media::all();
        return $data;
    }
    public function upload(Request $request){
        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png,csv,txt,xlx,xls,pdf|max:2048'
        ]);
        $media = new Media;
        if($request->file()){
            $file_name = time().'_'.$request->file->getClientOriginalName();
            $file_path = $request->file('file')->storeAs('uploads',$file_name,'public');
            $media->name = time().'_'.$request->file->getClientOriginalName();
            $media->path = '/storage/'.$file_path;
            $media->save();
            return response()->json([
                'success'=>'File uploaded Successfully'
            ]);
        }
    }
}
