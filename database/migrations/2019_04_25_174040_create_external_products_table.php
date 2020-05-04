<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExternalProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->longtext('file_path');
            $table->integer('count_products')->default(0);
            $table->integer('count_updated')->default(0);
            $table->integer('count_notfound')->default(0);
            $table->integer('step')->default(0);
            $table->enum('status', ['0','1','2','3','4','5','6','7','8','9'])->default('0');
            $table->timestamps();

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
        Schema::dropIfExists('external_products');
    }
}
