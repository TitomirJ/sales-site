<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->integer('order_id')->unsigned()->nullable();
            $table->enum('type_dk', ['0','1']);
            $table->enum('type_transaction', ['0','1','2','3','4']);
            $table->float('total_sum', 20, 2);
            $table->integer('data_ab')->nullable();
            $table->longText('data')->nullable();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['company_id', 'order_id']);
        });
        Schema::dropIfExists('transactions');
    }
}
