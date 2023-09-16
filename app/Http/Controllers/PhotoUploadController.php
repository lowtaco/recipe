<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoUploadController extends Controller
{
    public function store(Request $request)
    {
        $image = $request->input('image');
        $type = $request->input('type');
        $name = $request->input('name');
        $folder = $request->input('folder');

        $image_content = strstr($image, ',');

        $path = 'public/images/' . $folder . '/' . $name . '.' . $type;
        $url = 'storage/images/' . $folder . '/' . $name . '.' . $type;

        Storage::put($path, base64_decode($image_content));
        
        return $url;
 
    }
}
