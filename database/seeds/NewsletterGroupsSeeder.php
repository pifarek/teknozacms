<?php

use Illuminate\Database\Seeder;

class NewsletterGroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('newsletter_groups')->insert([
            'name' => 'Default Group',
        ]);
    }
}
