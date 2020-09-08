<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('likes', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('app_user_id');
            $table->unsignedBigInteger('article_id');
            Schema::dropIfExists('likes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('likes', function (Blueprint $table) {
            //
        });
    }
}
