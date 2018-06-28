<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MultimediaTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('multimedia_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('multimedia_id')->unsigned();
            $table->string('locale', '2');
            $table->string('name');
            $table->text('description')->nullable();

            $table->foreign('multimedia_id')->references('id')->on('multimedia')->onDelete('cascade');
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
        Schema::table('multimedia_translations', function (Blueprint $table) {
            $table->dropForeign(['multimedia_id']);
            $table->dropForeign(['locale']);
        });

        Schema::dropIfExists('multimedia_translations');
    }
}
