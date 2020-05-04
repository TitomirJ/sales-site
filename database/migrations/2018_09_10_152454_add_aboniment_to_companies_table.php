<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAbonimentToCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->enum('block_new', ['0','1'])->default('1')->after('kredit_sum');
            $table->enum('block_bal', ['0','1'])->default('0')->after('kredit_sum');
            $table->enum('block_ab', ['0','1'])->default('0')->after('kredit_sum');
            $table->time('ab_to')->nullable()->after('kredit_sum');
            $table->time('ab_from')->nullable()->after('kredit_sum');

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
            $table->dropColumn(['block_new', 'block_bal', 'block_ab', 'ab_from', 'ab_to']);
        });
    }
}
