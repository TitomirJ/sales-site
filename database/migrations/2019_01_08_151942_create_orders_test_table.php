<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_test', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->string('code')->nullable();
            $table->integer('user_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->integer('marketplace_id')->nullable()->unsigned();
            $table->string('name', 180);
            $table->longText('data_error')->nullable();
            $table->integer('quantity');
            $table->float('total_sum', 20, 2);
            $table->float('commission_sum', 20, 2);
            $table->enum('status', ['0','1','2','3','4','5','6','7','8','9'])->default('0');
            $table->longText('status_data')->nullable();
            $table->enum('moder_confirm', ['0','1'])->default('0');
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_adress')->nullable();
            $table->longText('comment')->nullable();
            $table->unsignedBigInteger('order_market_id')->nullable();
            $table->string('delivery_method', 180)->nullable();
            $table->string('payment_method', 180)->nullable();
            $table->string('ttn', 180)->nullable();
            $table->unsignedBigInteger('market_id');
            $table->string('market_state', 180)->nullable();
            $table->timestamp('market_added_on')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_test');
    }
}
