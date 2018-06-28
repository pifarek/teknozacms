<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProjectsTagProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects_tag_project', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('tag_id')->unsigned();
            $table->integer('project_id')->unsigned();

            $table->foreign('tag_id')->references('id')->on('projects_tags')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects_tag_project', function (Blueprint $table) {
            $table->dropForeign(['tag_id']);
            $table->dropForeign(['project_id']);
        });

        Schema::dropIfExists('projects_tag_project');
    }
}
