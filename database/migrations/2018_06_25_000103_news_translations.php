<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewsTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('news_id')->unsigned();
            $table->string('locale', '2');
            $table->text('title');
            $table->text('slug');
            $table->text('content');

            $table->foreign('news_id')->references('id')->on('news')->onDelete('cascade');
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
        Schema::table('news_translations', function (Blueprint $table) {
            $table->dropForeign(['news_id']);
            $table->dropForeign(['locale']);
        });

        Schema::dropIfExists('news_translations');
    }
}
