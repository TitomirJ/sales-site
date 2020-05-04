<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\TreshedImage;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class DropzoneImageController extends Controller
{
    public function uploadFiles() {

        $width = null;
        $height = 850;
        $zipping = 90;

        $photo = Input::file('file');
        $name = sha1(date('YmdHis') . str_random(30));
        $resize_name = $name . str_random(2) . '.' . $photo->getClientOriginalExtension();

        $image = Image::make($photo)->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
//            $constraint->upsize();
        })->save('images/uploads/' . $resize_name, $zipping);

        if($image){
            TreshedImage::firstOrCreate(
                [
                    'image_path' => 'images/uploads/'.$resize_name,
                    ],
                [
                'user_id' => Auth::user()->id,
                'image_path' => 'images/uploads/'.$resize_name,
                    ]
            );
        }

        if($image){
               return 'images/uploads/'.$resize_name;
           }else{
               return Response::json([
                   'status'=> 'danger',
                   'message' => 'Ошибка сервера, размер изображения слишком большой!'
               ], 500);
           }
    }

    public function deleteFiles(Request $request) {
        $filename = $request->id;
        $massage = unlink(public_path($filename));
        if($massage){
            TreshedImage::where('image_path', $filename)->delete();

            return Response::json([
                'status'=> 'success',
                'message' => 'Изображение успешно удалено!'
            ], 200);
        }else{
            return Response::json([
                'status'=> 'danger',
                'message' => 'Ошибка сервера, удаление не прошло!'
            ], 200);
        }

    }
}
