<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRozetkaChartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rozetka_charts', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('m_id')->unsigned();
            $table->index('m_id');
            $table->string('subject')->nullable();
            $table->integer('m_user_id')->unsigned();// relation rozetka_users => m_id
            $table->string('user_fio')->nullable();
            $table->enum('read_market', ['0','1','2','3'])->default('0');
            $table->enum('trash_market', ['0','1'])->default('0');
            $table->enum('star_market', ['0','1'])->default('0');
            $table->bigInteger('m_order_id')->unsigned()->nullable();
            $table->longtext('orders_ids')->nullable();
            $table->integer('m_product_id')->unsigned()->nullable();// relation products => rozetka_id
            $table->integer('product_id')->unsigned()->nullable();// relation products => id
            $table->enum('type', ['0','1','2','3','4','5']);
            $table->enum('admin_status', ['0','1'])->default('0');
            $table->integer('company_id')->unsigned()->nullable();// relation companies => id
            $table->longtext('companies_ids')->nullable();
            $table->timestamps();

        });

        Schema::table('rozetka_charts', function (Blueprint $table) {

            $table->foreign('m_user_id')->references('m_id')->on('rozetka_users')->onDelete('cascade');
            $table->foreign('m_product_id')->references('rozetka_id')->on('products')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rozetka_charts');
    }
}
