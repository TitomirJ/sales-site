<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->integer('subcategory_id')->unsigned()->nullable();
            $table->string('name', 180);
            $table->longText('desc');
            $table->string('code', 50);
            $table->string('brand', 180);
            $table->float('price', 20, 2);
            $table->float('old_price', 20, 2)->nullable();
            $table->longText('gallery');
            $table->string('video_url', 180)->nullable();
            $table->integer('user_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->enum('status_moderation', ['0','1','2','3'])->default('0');
            $table->enum('status_available', ['0','1'])->default('1');
            $table->longText('data')->nullable();
            $table->longText('options')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
