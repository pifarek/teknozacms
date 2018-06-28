<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ItemsTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('item_id')->unsigned();
            $table->string('locale', '2');
            $table->string('name');
            $table->text('url');
            $table->text('route')->nullable();

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
        Schema::table('items_translations', function (Blueprint $table) {
            $table->dropForeign(['item_id']);
            $table->dropForeign(['locale']);
        });

        Schema::dropIfExists('items_translations');
    }
}
