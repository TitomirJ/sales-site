<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\News;

class AdminBlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(){
        $blogs = News::paginate(10);
        return view('admin.blog.index', compact('blogs'))->withTitle('Новости');
    }

    public function show($id){
        $blog = News::find($id);
        return view('admin.blog.show', compact('blog'))->withTitle($blog->label);
    }

    public function create(){
        return view('admin.blog.create')->withTitle('Создание новостей');
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

            News::create([
                'label' => $request->label,
                'text' => $request->text,
                'image_path' => $new_image_path,
                'block' =>  $check_box,
            ]);

            Session::flash('success', 'Новость успешно создана!');

            return redirect('/admin/blog')->withTitle('Новости');

        }else{
            return back()->with('danger', 'Ошибка сервера!');
        }

    }

    public function edit($id){
        $blog = News::find($id);
        return view('admin.blog.edit', compact('blog'))->withTitle('Редактирование новостей');
    }

    public function update(Request $request){
        if($request->method() == 'POST'){

            $blog = News::find($request->blog_id);

            if($request->hasFile('image_path')) {
                self::deleteImage($blog->image_path);
                $new_image_path = self::uploadImage($request->file('image_path'));

                $blog->image_path = $new_image_path;
            }

            $check_box = '0';
            if(isset($request->block)){
                $check_box = $request->block;
            }

            $blog->label = $request->label;
            $blog->text = $request->text;
            $blog->block = $check_box;

            $blog->save();

            Session::flash('success', 'Новость успешно изменена!');

            return redirect('/admin/blog')->withTitle('Новости');
        }else{

            Session::flash('danger', 'Ошибка сервера!');

            return redirect('/admin/blog')->withTitle('Новости');
        }
    }

    public function delete(Request $request, $id){

        $blog = News::find($id);

        if(($blog->image_path == '') ||($blog->image_path == null)){
            $blog->delete();
        }else{
            self::deleteImage($blog->image_path);
            $blog->delete();
        }

        Session::flash('success', 'Новость успешно удалена!');

        return redirect('/admin/blog')->withTitle('Новости');
    }

    private function uploadImage($photo){

        $name = sha1(date('YmdHis') . str_random(30));
        $resize_name = $name . str_random(2) . '.' . $photo->getClientOriginalExtension();
        $new_image_path = 'images/uploads/'.$resize_name;
        Image::make($photo)->resize(800, 1200)->save('images/uploads/' . $resize_name);

        return $new_image_path;
    }

    private function deleteImage($image_path){
        unlink($image_path);
    }

    public function changeStatusBlog(Request $request, $id){

        $blog = News::find($id);
        if($blog->block == '1'){
            $blog->block = '0';
            $blog->save();

            return 'no';
        }else{
            $blog->block = '1';
            $blog->save();

            return 'ok';
        }
    }
}
