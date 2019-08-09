<?php

use Illuminate\Database\Seeder;

class LocalesAcceptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('locales_accept')->insert([
            'locale_id' => 1,
            'name' => 'en'
        ]);

        DB::table('locales_accept')->insert([
            'locale_id' => 1,
            'name' => 'en-GB'
        ]);

        DB::table('locales_accept')->insert([
            'locale_id' => 1,
            'name' => 'en_GB'
        ]);

        DB::table('locales_accept')->insert([
            'locale_id' => 1,
            'name' => 'en_US'
        ]);

        DB::table('locales_accept')->insert([
            'locale_id' => 1,
            'name' => 'en-US'
        ]);

        DB::table('locales_accept')->insert([
            'locale_id' => 2,
            'name' => 'pl'
        ]);

        DB::table('locales_accept')->insert([
            'locale_id' => 2,
            'name' => 'pl-PL'
        ]);

        DB::table('locales_accept')->insert([
            'locale_id' => 2,
            'name' => 'pl_PL'
        ]);
    }
}
