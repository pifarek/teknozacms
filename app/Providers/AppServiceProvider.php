<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Enable foreign keys
        Schema::enableForeignKeyConstraints();

        // Default length of mysql key names
        Schema::defaultStringLength(191);

        // Set the page language
        /**
        if(\Cookie::get('locale')) {
            $locale_language = json_decode(\Cookie::get('locale'))->language; 

            $locale = Locale::where('language', '=', $locale_language)->get()->first();
            if($locale) {
                \App::setLocale($locale->language);
                // Set also the locale for date class
                \Date::setLocale(\App::getLocale());
            }
        }
        */

        // Add additional translations
        foreach(\Teknoza::Translations() as $translation) {
            \Lang::addNamespace($translation['namespace'], $translation['path']);
        }

        /**
        // Set up a smtp relay
        config(['mail.host' => \Settings::get('smtp_host')]);
        config(['mail.port' => \Settings::get('smtp_port')]);
        config(['mail.username' => \Settings::get('smtp_user')]);
        config(['mail.password' => \Settings::get('smtp_pass')]);
        config(['mail.from' => ['address' => \Settings::get('email'), 'name' => \Settings::get('email')]]);
        **/
        // Share the list of front-end locales
        //$locales = \App\Models\Locale::all();
        //View::share('front_locales', $locales);
        


    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
