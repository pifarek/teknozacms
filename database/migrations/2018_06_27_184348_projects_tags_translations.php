<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProjectsTagsTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects_tags_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('tag_id')->unsigned();
            $table->string('locale', '2');
            $table->string('name');

            $table->foreign('tag_id')->references('id')->on('projects_tags')->onDelete('cascade');
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
        Schema::table('projects_tags_translations', function (Blueprint $table) {
            $table->dropForeign(['tag_id']);
            $table->dropForeign(['locale']);
        });

        Schema::dropIfExists('projects_tags_translations');
    }
}
