<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ContactsTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('contact_id')->unsigned();
            $table->string('locale', '2');
            $table->string('name');
            $table->text('description');

            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
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
        Schema::table('contacts_translations', function (Blueprint $table) {
            $table->dropForeign(['contact_id']);
            $table->dropForeign(['locale']);
        });

        Schema::dropIfExists('contacts_translations');
    }
}
