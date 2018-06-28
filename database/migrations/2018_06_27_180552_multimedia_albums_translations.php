<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MultimediaAlbumsTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('multimedia_albums_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('album_id')->unsigned();
            $table->string('locale', '2');
            $table->string('name');

            $table->foreign('album_id')->references('id')->on('multimedia_albums')->onDelete('cascade');
            $table->foreign('locale')->references('language')->on('locales')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('multimedia_albums_translations', function (Blueprint $table) {
            $table->dropForeign(['album_id']);
            $table->dropForeign(['locale']);
        });

        Schema::dropIfExists('multimedia_albums_translations');
    }
}
