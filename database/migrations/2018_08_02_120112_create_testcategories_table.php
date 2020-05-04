<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('testcategories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('market_cat_id')->nullable();
            $table->string('name', 180);
            $table->float('commission')->nullable();
            $table->longText('data')->nullable();
            $table->timestamps();
        });

        Schema::create('testcategories_testthemes', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('testcategory_id')->unsigned();
            $table->integer('testtheme_id')->unsigned();
            $table->timestamps();
            $table->foreign('testcategory_id')->references('id')->on('testcategories')->onDelete('cascade');
            $table->foreign('testtheme_id')->references('id')->on('testthemes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('testcategories');
        Schema::dropIfExists('testcategories_testthemes');
    }
}
