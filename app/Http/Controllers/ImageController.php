<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class ImageController extends Controller
{
    public static function insertImage($id , $image){
        Image::create([
            "product" => $id ,
            'imageName' => $image
        ]);
    }

    public function deleteImage(string $id , string $pid){
        $image = Image::findOrFail($id);
        unlink( public_path('images/Products/').$image->imageName);
        $image->delete();

        return redirect(route('editProduct' , $pid));
    }
}
