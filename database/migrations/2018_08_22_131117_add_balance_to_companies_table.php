<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBalanceToCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->float('kredit_sum', 20, 2)->default(0)->after('info');
            $table->float('debet_sum', 20, 2)->default(0)->after('info');
            $table->float('balance_limit', 20, 2)->default(500)->after('info');
            $table->float('balance_sum', 20, 2)->default(0)->after('info');
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
            $table->dropColumn(['kredit_sum', 'debet_sum', 'balance_limit', 'balance_sum']);
        });
    }
}
