<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\News;
use Illuminate\Support\Facades\View;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Инструкция для длины строки в БД
        Schema::defaultStringLength(191);
        View::share('globalTitle', 'Big Sales');
        // Сохранение в глобальную переменную новостей(статус: не заблокировано)
        $blogs = News::where('block', '1')->get();
        if($blogs->count() >= 1){
            View::share('blogs', $blogs);
        }


        // вывод всех запросов в БД на страницу(использовать для проверки количества запросов в базу данных)
//        DB::listen(function($query){
//            dump($query->sql);
//       });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
