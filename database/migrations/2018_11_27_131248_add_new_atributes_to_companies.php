<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewAtributesToCompanies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->enum('tariff_plan', ['0','1','2','3','4','5'])->default('0')->after('info');
            $table->longText('data')->nullable()->after('info');
            $table->enum('type_company', ['0','1','2','3','4','5','6','7','8','9','10','11'])->default('0')->after('info');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['tariff_plan', 'data', 'type_company']);
        });
    }
}
