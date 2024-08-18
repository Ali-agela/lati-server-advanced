<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploaderController extends Controller
{
    public function upload(Request $request){
    $request->validate([
            'img'=>['mimes:jpg,png', 'max:1024']
        ]);
        $img = $request->file('img')->store('/avatars', 'public');
        return response()->json([
            'message' => 'image uploaded successfully',
            'image_name' => $img
        ]);
    }
    
}
