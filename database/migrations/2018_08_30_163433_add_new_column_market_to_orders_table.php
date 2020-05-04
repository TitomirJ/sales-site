<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnMarketToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('ttn', 180)->nullable()->after('comment');
            $table->string('payment_method', 180)->nullable()->after('comment');
            $table->string('delivery_method', 180)->nullable()->after('comment');
            $table->bigInteger('order_market_id')->unsigned()->nullable()->after('comment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {

            $table->dropColumn(['ttn', 'payment_method', 'delivery_method', 'order_market_id']);
        });
    }
}
