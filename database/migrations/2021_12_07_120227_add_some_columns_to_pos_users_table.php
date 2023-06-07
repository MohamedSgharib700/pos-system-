<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeColumnsToPosUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pos_users', function (Blueprint $table) {
            $table->after('id', function ($table) {
                $table->unsignedBigInteger('company_id');
                $table->foreign('company_id')->on('companies')->references('id')->onDelete('no action');
                $table->unsignedBigInteger('branch_id')->nullable();
                $table->foreign('branch_id')->on('branches')->references('id')->onDelete('no action');
            });
            $table->after('forget_code', function ($table) {
                $table->string('phone', 20);
                $table->string('serial_number');
                $table->string('serial_code');
                $table->string('identification_number');
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pos_users', function (Blueprint $table) {
            $table->dropForeign('pos_users_company_id_foreign');
            $table->dropForeign('pos_users_branch_id_foreign');
            $table->dropColumn('company_id', 'branch_id', 'phone', 'serial_number', 'serial_code', 'identification_number');
        });
    }
}
