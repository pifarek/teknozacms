<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EventsTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('event_id')->unsigned();
            $table->string('locale', '2');
            $table->string('name');
            $table->text('description')->nullable();

            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
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
        Schema::table('events_translations', function (Blueprint $table) {
            $table->dropForeign(['event_id']);
            $table->dropForeign(['locale']);
        });

        Schema::dropIfExists('events_translations');
    }
}
