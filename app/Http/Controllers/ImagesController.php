<?php

namespace App\Http\Controllers;

use App\Models\Image;
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

         $image->save(storage_path('app/public/uploads/' . $imageName));
        
        Image::create([
            "url"=>"storage/uploads/".$imageName,
            "product_id"=>$request->get('product_id')
        ]);
        return response()->json(['path' => "storage/uploads/".$imageName], 201);
    }
    public function findImagesByProductId(Request $request){
        $validator = Validator::make($request->all(),[
            "id"=>"required|numeric"
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        $result = Image::where('product_id', $request->get('id'))->get();
        return response()->json($result,200);

        
    }
    public function deleteImages(Request $request){
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',          // Debe ser un array y no estar vacío
            'ids.*' => 'integer|min:1'          // Cada ID debe ser un número entero y mayor a 0
        ]);
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 422);
        }
        Image::destroy($request->get('ids'));
        return response()->json(["message"=>"Imagenes eliminadas!"],200);
    }
}
