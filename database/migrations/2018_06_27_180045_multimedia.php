<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Multimedia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('multimedia', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('album_id')->nullable()->unsigned();
            $table->smallInteger('featured')->default(0);
            $table->enum('type', ['image', 'video']);
            $table->integer('order');

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
        Schema::table('multimedia', function (Blueprint $table) {
            $table->dropForeign(['album_id']);
        });

        Schema::dropIfExists('multimedia');
    }
}
