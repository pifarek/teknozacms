<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SlidesTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slides_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('slide_id')->unsigned();
            $table->string('locale', '2');
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('button_label')->nullable();

            $table->foreign('slide_id')->references('id')->on('slides')->onDelete('cascade');
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
        Schema::table('slides_translations', function (Blueprint $table) {
            $table->dropForeign(['slide_id']);
            $table->dropForeign(['locale']);
        });

        Schema::dropIfExists('slides_translations');
    }
}
