<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LocalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('locales')->insert([
            'language' => 'en',
            'name' => 'English',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('locales')->insert([
            'language' => 'pl',
            'name' => 'Polski',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
