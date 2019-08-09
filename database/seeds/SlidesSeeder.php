<?php

use Illuminate\Database\Seeder;

class SlidesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('slides')->insert([
            'slider_id' => '1',
            'filename' => 'example1.jpg',
            'order' => 0
        ]);

        DB::table('slides_translations')->insert([
            'slide_id' => 1,
            'locale' => 'en',
            'name' => 'TeknozaCMS slide example #1',
            'description' => 'Slider description example',
        ]);

        DB::table('slides_translations')->insert([
            'slide_id' => 1,
            'locale' => 'pl',
            'name' => 'TeknozaCMS przykładowy slajd #1',
            'description' => 'Przykładowy opis slajdu',
        ]);

        DB::table('slides')->insert([
            'slider_id' => '1',
            'filename' => 'example2.jpg',
            'order' => 0
        ]);

        DB::table('slides_translations')->insert([
            'slide_id' => 2,
            'locale' => 'en',
            'name' => 'TeknozaCMS slide example #2',
            'description' => 'do we need description?',
        ]);

        DB::table('slides_translations')->insert([
            'slide_id' => 2,
            'locale' => 'pl',
            'name' => 'TeknozaCMS przykładowy slajd #2',
            'description' => 'Przykładowy opis slajdu',
        ]);
    }
}
