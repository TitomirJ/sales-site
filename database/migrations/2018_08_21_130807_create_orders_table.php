<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->integer('marketplace_id')->nullable()->unsigned();
            $table->string('name', 180);
            $table->longText('data_error')->nullable();
            $table->integer('quantity');
            $table->float('total_sum', 20, 2);
            $table->float('commission_sum', 20, 2);
            $table->enum('status', ['0','1','2','3','4','5','6','7','8','9'])->default('0');
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_adress')->nullable();
            $table->longText('comment')->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('marketplace_id')->references('id')->on('marketplaces');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('company_id');
            $table->dropForeign('product_id');
            $table->dropForeign('marketplace_id');
        });
    }
}
