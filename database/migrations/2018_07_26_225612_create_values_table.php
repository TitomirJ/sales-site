<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('values', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('rozet_id')->unsigned();
            $table->text('name');
            $table->timestamps();
        });

        Schema::create('parametrs_values', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('parametr_id')->unsigned();
            $table->integer('value_id')->unsigned();
            $table->timestamps();
            $table->foreign('parametr_id')->references('id')->on('parametrs')->onDelete('cascade');
            $table->foreign('value_id')->references('id')->on('values')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('values');
        Schema::dropIfExists('parametrs_values');
    }
}
