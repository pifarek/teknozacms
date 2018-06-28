<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewsletterUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newsletter_users', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->string('email')->unique();
            $table->text('name')->nullable();
            $table->text('surname')->nullable();
            $table->integer('group_id')->unsigned()->nullable();
            $table->text('unsubscribe_hash')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('newsletter_users');
    }
}
