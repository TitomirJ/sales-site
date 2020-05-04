<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMarketplaceOnToCompanies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->enum('zakupka_on', ['0','1'])->default('1')->after('moderator_id');
            $table->enum('prom_on', ['0','1'])->default('1')->after('moderator_id');
            $table->enum('rozetka_on', ['0','1'])->default('1')->after('moderator_id');
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
            $table->dropColumn(['rozetka_on', 'prom_on', 'zakupka_on']);
        });
    }
}
