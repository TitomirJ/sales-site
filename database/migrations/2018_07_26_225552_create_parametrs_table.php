<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParametrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parametrs', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('rozet_id')->unsigned();
            $table->text('name');
            $table->string('attr_type', 150);
            $table->timestamps();
        });

        Schema::create('subcategories_parametrs', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('subcategory_id')->unsigned();
            $table->integer('parametr_id')->unsigned();
            $table->timestamps();
            $table->foreign('subcategory_id')->references('id')->on('subcategories')->onDelete('cascade');
            $table->foreign('parametr_id')->references('id')->on('parametrs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parametrs');
        Schema::dropIfExists('subcategories_parametrs');
    }
}
