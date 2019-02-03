<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'email' => 'admin@teknoza.be',
            'password' => bcrypt('administrator'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'locale' => 'en',
            'is_active' => 1
        ]);
    }
}
