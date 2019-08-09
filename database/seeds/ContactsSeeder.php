<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ContactsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $id = DB::table('contacts')->insertGetId([
            'street' => 'Gitschotellei 387',
            'postal' => 2140,
            'city' => 'Borgerhout (Antwerpen)',
            'phone' => '03 233 77 25',
            'fax' => '03 233 77 25',
            'email' => 'info@teknoza.be',
        ]);

        DB::table('contacts_translations')->insert([
            'contact_id' => $id,
            'locale' => 'en',
            'name' => 'Teknoza.be',
            'description' => $faker->paragraphs(3, true),
        ]);

        DB::table('contacts_translations')->insert([
            'contact_id' => $id,
            'locale' => 'pl',
            'name' => 'Teknoza.be',
            'description' => $faker->paragraphs(3, true),
        ]);
    }
}
