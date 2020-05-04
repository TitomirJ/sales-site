<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRozetkaUsersTable extends Migration
{

    public function up()
    {
        Schema::create('rozetka_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('m_id')->unsigned();
            $table->index('m_id');
            $table->string('email')->nullable();
            $table->string('login')->nullable();
            $table->string('contact_fio')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('rozetka_users');
    }
}
