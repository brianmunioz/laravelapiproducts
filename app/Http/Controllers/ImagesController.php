<?php

namespace App\Http\Controllers;

use App\Models\Images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ImagesController extends Controller
{
    public function uploadImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "product_id" => "required|numeric",

            "photo" => [
                "required",
                "file",
                'mimes:jpg,webp,png,jpeg',
                'max:5120'
            ],
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        $manager = new ImageManager(new Driver());
        $image = $manager->read($request->file('photo'));
        $image->toWebp(60);
        $imageName = time() ."-".$request->get('product_id') . '.webp';
        $path = $image->save(storage_path('app/public/uploads/' . $imageName));
        echo "antes si:".$path;
        Images::create([
            "url"=>"storage/uploads/".$imageName,
            "product_id"=>$request->get('product_id')
        ]);
        return response()->json(['path' => $path], 201);
    }
}
