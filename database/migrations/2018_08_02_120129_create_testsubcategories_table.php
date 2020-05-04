<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestsubcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('testsubcategories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('testcategory_id')->unsigned();
            $table->integer('market_subcat_id')->nullable();
            $table->string('name', 180);
            $table->float('commission')->nullable();
            $table->longText('data')->nullable();
            $table->timestamps();

            $table->foreign('testcategory_id')->references('id')->on('testcategories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('testsubcategories');
    }
}
