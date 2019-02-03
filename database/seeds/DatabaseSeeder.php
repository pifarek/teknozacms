<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LocalesSeeder::class);
        $this->call(ContactsSeeder::class);
        $this->call(AdministratorsSeeder::class);
        $this->call(SettingsSeeder::class);
        $this->call(NewsletterGroupsSeeder::class);
        $this->call(SliderSeeder::class);
        $this->call(SlidesSeeder::class);
        $this->call(MenusSeeder::class);
        $this->call(ItemsSeeder::class);
    }
}
