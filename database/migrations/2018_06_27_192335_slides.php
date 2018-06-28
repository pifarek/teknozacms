<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Slides extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slides', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('slider_id')->unsigned();
            $table->string('filename', 100);
            $table->text('url')->nullable();
            $table->smallInteger('blank')->default(0);
            $table->smallInteger('available_date')->default(0);
            $table->integer('start_date')->default(0);
            $table->integer('end_date')->default(0);
            $table->integer('order')->default(0);

            $table->foreign('slider_id')->references('id')->on('sliders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slides', function (Blueprint $table) {
            $table->dropForeign(['slider_id']);
        });

        Schema::dropIfExists('slides');
    }
}
