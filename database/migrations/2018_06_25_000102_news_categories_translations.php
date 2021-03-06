<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewsCategoriesTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_categories_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->string('locale', '2');
            $table->string('name');

            $table->foreign('category_id')->references('id')->on('news_categories')->onDelete('cascade');
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
        Schema::table('news_categories_translations', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['locale']);
        });

        Schema::dropIfExists('news_categories_translations');
    }
}
