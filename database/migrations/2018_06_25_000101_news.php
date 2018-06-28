<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class News extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('category_id')->nullable()->unsigned();
            $table->integer('album_id')->nullable()->unsigned();
            $table->string('filename')->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('news_categories')->onDelete('set null');
            $table->foreign('album_id')->references('id')->on('multimedia_albums')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['album_id']);
        });

        Schema::dropIfExists('news');
    }
}
