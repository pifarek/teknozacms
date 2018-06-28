<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('avatar')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->text('remember_token')->nullable();
            $table->text('reset_token')->nullable();
            $table->timestamps();
            $table->timestamp('active_at')->nullable();
            $table->enum('role', ['administrator', 'user'])->deault('user');
            $table->string('front_locale', 2)->nullable();
            $table->string('back_locale', 2)->nullable();
            $table->integer('is_active')->default(0)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
