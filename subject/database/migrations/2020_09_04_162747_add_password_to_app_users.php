<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPasswordToAppUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('app_users', function (Blueprint $table) {
            //
            $table->string('password', 50)->after('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('app_users', function (Blueprint $table) {
            //
            $table->dropColumn('password');
        });
    }
}
