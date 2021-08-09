<?php

namespace App\Http\Controllers\Product;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ProductImageController extends Controller
{
    public function upload(Request $request){
        $file = $request->file('image');
        $file_name = Str::random(10);

        $url = Storage::putFileAs('images', $file, $file_name.'.'.$file->extension());

        return response()->json([
            'message' => 'Image uploaded successfully',
            'url' => config('app.url').'/'.$url
        ], Response::HTTP_CREATED);
    }
}
