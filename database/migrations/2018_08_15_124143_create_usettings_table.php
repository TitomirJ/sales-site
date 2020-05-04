<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usettings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('n_par_1')->default(10)->nullable();
            $table->integer('n_par_2')->nullable();
            $table->integer('n_par_3')->nullable();
            $table->integer('n_par_4')->nullable();
            $table->integer('n_par_5')->nullable();
            $table->string('s_par_1', 160)->nullable();
            $table->string('s_par_2', 160)->nullable();
            $table->string('s_par_3', 160)->nullable();
            $table->string('s_par_4', 160)->nullable();
            $table->string('s_par_5', 160)->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usettings');
    }
}
