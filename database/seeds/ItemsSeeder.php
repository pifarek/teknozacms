<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        DB::table('items')->insert([
            'menu_id' => 1,
            'type' => 'html'
        ]);

        DB::table('items_translations')->insert([
            'item_id' => 1,
            'locale' => 'en',
            'name' => 'About Us',
            'url' => 'about-us',
            'route' => 'about-us',
        ]);

        DB::table('custom')->insert([
            'item_id' => 1,
            'locale' => 'en',
            'name' => 'content',
            'value' => '<p>' . $faker->paragraphs(7, true) . '</p>'
        ]);

        DB::table('items')->insert([
            'menu_id' => 1,
            'type' => 'contact',
            'order' => 1
        ]);

        DB::table('items_translations')->insert([
            'item_id' => 2,
            'locale' => 'en',
            'name' => 'Contact',
            'url' => 'contact',
            'route' => 'contact',
        ]);

        DB::table('custom')->insert([
            'item_id' => 2,
            'name' => 'contact_id',
            'value' => 1
        ]);
    }
}
