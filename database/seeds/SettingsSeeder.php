<?php

use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            'locale_id' => 1,
            'name' => 'title',
            'value' => 'Teknoza.be'
        ]);

        DB::table('settings')->insert([
            'locale_id' => 1,
            'name' => 'description',
            'value' => 'Teknoza.be Content Management System'
        ]);

        DB::table('settings')->insert([
            'name' => 'email',
            'value' => 'info@teknoza.be'
        ]);

        DB::table('settings')->insert([
            'name' => 'newsletter_default_group',
            'value' => '1'
        ]);

        DB::table('settings')->insert([
            'name' => 'smtp_host',
            'value' => 'smtp.mailtrap.io'
        ]);

        DB::table('settings')->insert([
            'name' => 'smtp_user',
            'value' => '28ff96bc4f966c'
        ]);

        DB::table('settings')->insert([
            'name' => 'smtp_pass',
            'value' => '893743808d66e5'
        ]);

        DB::table('settings')->insert([
            'name' => 'smtp_port',
            'value' => '465'
        ]);

        DB::table('settings')->insert([
            'name' => 'smtp_from',
            'value' => 'info@teknoza.be'
        ]);
    }
}
