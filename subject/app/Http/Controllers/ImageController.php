<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    //
    public function create(){

        return view('article.image');
    }

    public function confirm(Request $request){
        $image = $request->file('article_image');
        $temp_path = $image->store('public/images');
        $read_temp_path = str_replace('public/', 'storage/', $temp_path);

        $image_data = [
            'temp_path' => $temp_path,
            'read_temp_path' => $read_temp_path,
        ];

        return view('article.image_confirm', compact('image_data'));
    }
}
