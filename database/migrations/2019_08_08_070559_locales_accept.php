<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LocalesAccept extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locales_accept', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->unsignedInteger('locale_id');
            $table->string('name');

            $table->foreign('locale_id')->references('id')->on('locales')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('locales_accept', function (Blueprint $table) {
            $table->dropForeign(['locale_id']);
        });

        Schema::dropIfExists('locales');
    }
}
