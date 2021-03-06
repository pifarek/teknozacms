<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Validator;

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

        // Validate Video URL
        Validator::extend('video', function($attribute, $value, $parameters){
            $patterns = array(
                array(
                    'pattern' => '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',
                    'type' => 'youtube'
                )
            );

            foreach($patterns as $pattern){
                preg_match_all($pattern["pattern"], $value, $matches);
                if(!empty($matches[1])){
                    return true;
                }
            }
            return false;
        });

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
