<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsActiveToPosUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pos_users', function (Blueprint $table) {
            $table->boolean('is_active')->comment('1 => the pos user is active , 0 => the pos user unactive')->default(0)->after('password');
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
            $table->dropColumn('is_active');
        });
    }
}
