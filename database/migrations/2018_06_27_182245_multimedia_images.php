<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MultimediaImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('multimedia_images', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('multimedia_id')->unsigned();
            $table->string('filename', '100');

            $table->foreign('multimedia_id')->references('id')->on('multimedia')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('multimedia_images', function (Blueprint $table) {
            $table->dropForeign(['multimedia_id']);
        });

        Schema::dropIfExists('multimedia_images');
    }
}
