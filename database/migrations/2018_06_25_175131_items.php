<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Items extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('menu_id')->unsigned();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->string('type')->nullable();
            $table->string('image')->nullable();
            $table->integer('order')->default(0);
            $table->smallInteger('default')->default(0);

            $table->foreign('parent_id')->references('id')->on('items')->onDelete('set null');
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropForeign(['menu_id']);
        });

        Schema::dropIfExists('items');
    }
}
