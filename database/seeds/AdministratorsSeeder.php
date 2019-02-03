<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AdministratorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('administrators')->insert([
            'email' => 'admin@teknoza.be',
            'password' => bcrypt('administrator'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'locale' => 'en'
        ]);
    }
}
