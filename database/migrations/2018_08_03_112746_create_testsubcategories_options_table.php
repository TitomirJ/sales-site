<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestsubcategoriesOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('testsubcategories_options', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('testsubcategory_id')->unsigned();
            $table->longText('options');
            $table->timestamps();

            $table->foreign('testsubcategory_id')->references('id')->on('testsubcategories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('testsubcategories_options');
    }
}
