<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\Review;

class AdminReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(){
        $reviews = Review::paginate(10);
        return view('admin.review.index', compact('reviews'))->withTitle('Отзывы');
    }

    public function show($id){
        $review = Review::find($id);
        return view('admin.review.show', compact('review'))->withTitle($review->label);
    }

    public function create(){
        return view('admin.review.create')->withTitle('Создание отзывов');
    }

    public function store(Request $request){
        if($request->method() == 'POST'){

            if($request->hasFile('image_path')) {
                $new_image_path = self::uploadImage($request->file('image_path'));
            }else{
                $new_image_path = null;
            }

            $check_box = '0';
            if(isset($request->block)){
                $check_box = $request->block;
            }

            Review::create([
                'label' => $request->label,
                'text' => $request->text,
                'image_path' => $new_image_path,
                'block' =>  $check_box,
            ]);

            Session::flash('success', 'Отзыв успешно создан!');

            return redirect('/admin/review')->withTitle('Отзывы');

        }else{
            return back()->with('danger', 'Ошибка сервера!');
        }

    }

    public function edit($id){
        $review = Review::find($id);
        return view('admin.review.edit', compact('review'))->withTitle('Редактирование отзыва');
    }

    public function update(Request $request){
        if($request->method() == 'POST'){

            $review = Review::find($request->review_id);

            if($request->hasFile('image_path')) {
                self::deleteImage($review->image_path);
                $new_image_path = self::uploadImage($request->file('image_path'));

                $review->image_path = $new_image_path;
            }

            $check_box = '0';
            if(isset($request->block)){
                $check_box = $request->block;
            }

            $review->label = $request->label;
            $review->text = $request->text;
            $review->block = $check_box;

            $review->save();

            Session::flash('success', 'Отзыв успешно изменен!');

            return redirect('/admin/review')->withTitle('Отзывы');
        }else{

            Session::flash('danger', 'Ошибка сервера!');

            return redirect('/admin/review')->withTitle('Отзывы');
        }
    }

    public function delete(Request $request, $id){

        $review = Review::find($id);

        if(($review->image_path == '') ||($review->image_path == null)){
            $review->delete();
        }else{
            self::deleteImage($review->image_path);
            $review->delete();
        }

        Session::flash('success', 'Отзыв успешно удален!');

        return redirect('/admin/review')->withTitle('Отзывы');
    }

    private function uploadImage($photo){

        $name = sha1(date('YmdHis') . str_random(30));
        $resize_name = $name . str_random(2) . '.' . $photo->getClientOriginalExtension();
        $new_image_path = 'images/uploads/'.$resize_name;
        Image::make($photo)->resize(500, 400)->save('images/uploads/' . $resize_name);

        return $new_image_path;
    }

    private function deleteImage($image_path){
        unlink($image_path);
    }

    public function changeStatusReview(Request $request, $id){

        $review = Review::find($id);
        if($review->block == '1'){
            $review->block = '0';
            $review->save();

            return 'no';
        }else{
            $review->block = '1';
            $review->save();

            return 'ok';
        }
    }
}
