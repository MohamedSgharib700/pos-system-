<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditBankIdColumnInBanksAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('banks_accounts', function (Blueprint $table) {
            $table->dropForeign(['bank_id']);
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('banks_accounts', function (Blueprint $table) {
            $table->dropForeign(['bank_id']);
            $table->foreign('bank_id')->references('id')->on('banks')->cascadeOnDelete();
        });
    }
}
