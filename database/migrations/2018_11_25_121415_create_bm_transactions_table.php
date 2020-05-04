<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBmTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bm_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 50);
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->integer('currency_id')->unsigned();
            $table->float('amount', 20, 2);
            $table->longText('description');
            $table->enum('status', ['0','1','2','3','4'])->default('0');
            $table->timestamps();

            $table->foreign('currency_id')->references('id')->on('currencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bm_transactions', function (Blueprint $table) {
            $table->dropForeign('currency_id');
        });

        Schema::dropIfExists('bm_transactions');
    }
}
