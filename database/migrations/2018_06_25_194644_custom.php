<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Custom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('item_id')->unsigned();
            $table->string('locale', '2')->nullable();
            $table->text('name');
            $table->text('value')->nullable();

            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
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
        Schema::table('custom', function (Blueprint $table) {
            $table->dropForeign(['item_id']);
            $table->dropForeign(['locale']);
        });

        Schema::dropIfExists('custom');
    }
}
