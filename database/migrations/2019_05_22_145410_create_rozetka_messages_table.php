<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRozetkaMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rozetka_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('chart_id')->unsigned();
            $table->bigInteger('m_chart_id')->unsigned();
            $table->longtext('body')->nullable();
            $table->bigInteger('m_receiver_id')->unsigned();
            $table->enum('sender', ['0','1','2','3']);
            $table->timestamp('m_created_at')->nullable();
            $table->timestamps();
        });

        Schema::table('rozetka_messages', function (Blueprint $table) {
            $table->foreign('chart_id')->references('id')->on('rozetka_charts')->onDelete('cascade');
            $table->foreign('m_chart_id')->references('m_id')->on('rozetka_charts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rozetka_messages');
    }
}
