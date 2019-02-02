<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
 * Administrator routes
 */
Route::get('administrator/auth/login', 'App\Http\Controllers\Administrator\AuthController@form');
Route::post('administrator/auth/login', 'App\Http\Controllers\Administrator\AuthController@login');
Route::get('administrator/auth/reset', 'App\Http\Controllers\Administrator\AuthController@resetForm');
Route::get('administrator/auth/reset/{token}', 'App\Http\Controllers\Administrator\AuthController@generate');
Route::post('administrator/auth/reset', 'App\Http\Controllers\Administrator\AuthController@reset');
Route::any('administrator/auth/logout', 'App\Http\Controllers\Administrator\AuthController@logout');

// We need to be authenticated to view administrator pages
Route::group(['middleware' => 'auth.teknoza:administrator', 'prefix' => 'administrator'], function() {
    // Dashboard
    Route::get('/', 'App\Http\Controllers\Administrator\IndexController@dashboard');

    // Save fullscreen settings
    Route::get('json/fullscreen', 'App\Http\Controllers\Administrator\JsonController@fullscreen');

    // JSON
    //Route::controller('administrator/json', 'Administrator\JsonController');
    
    // Locale
    Route::get('locale/{id}', 'App\Http\Controllers\Administrator\IndexController@locale');

    // Administrator Profile
    Route::group(['prefix' => 'profile', 'namespace' => 'App\Http\Controllers\Administrator'], function() {
        Route::get('/', 'ProfileController@getIndex');
        Route::post('/', 'ProfileController@postIndex');
        Route::get('json/remove-avatar', 'ProfileController@avatarRemove');
        Route::post('json/avatar', 'ProfileController@avatar');
    });

    // Settings
    Route::group(['prefix' => 'settings', 'namespace' => 'App\Http\Controllers\Administrator\Settings'], function() {
        // Global Settings
        Route::get('global', 'IndexController@getGlobal');
        Route::post('global', 'IndexController@postGlobal');
        
        // Users management
        Route::group(['prefix' => 'users'], function() {
            
            // Display list of users
            Route::get('list', 'IndexController@getUsers');
            
            // Add a new user
            Route::get('add', 'IndexController@getUserAdd');
            Route::post('add', 'IndexController@postUserAdd');
            
            // Edit selected user
            Route::get('edit/{user_id}', 'IndexController@getUserEdit');
            Route::post('edit/{user_id}', 'IndexController@postUserEdit');
            
            // Remove selected user
            Route::get('json/user-remove/{user_id}', 'JsonController@userRemove');
        });

        // Statistics
        Route::resource('statistics', 'StatisticsController', ['except' => ['destroy']]);

        // Locales management
        Route::group(['prefix' => 'locales'], function() {
            
            // Display list of locales
            Route::get('list', 'IndexController@getLocales');
            
            // Add a new locale
            Route::get('add', 'IndexController@getLocaleAdd');
            Route::post('add', 'IndexController@postLocaleAdd');
            
            // Edit selected locale
            Route::get('edit/{locale_id}', 'IndexController@getLocaleEdit');
            Route::post('edit/{locale_id}', 'IndexController@postLocaleEdit');
            
            // Remove selected locale
            Route::get('json/locale-remove/{locale_id}', 'JsonController@localeRemove');
        });
        
        // Translations
        Route::get('translations', 'IndexController@getTranslations');
        Route::post('translations', 'IndexController@postTranslations');
        Route::get('json/translation-edit/{file}', 'JsonController@translationEdit');
        
        //Route::controller('administrator/settings/json', 'Administrator\Settings\JsonController');
        //Route::controller('administrator/settings', 'Administrator\Settings\IndexController');
    });

});

/**
 * Reset user password
 */
Route::get('reset/{token}', 'App\Http\Controllers\Page\IndexController@reset');
/**
 * Change user locale
 */
Route::get('locale/{id}', 'App\Http\Controllers\Page\IndexController@locale');

//Route::controller('page/json', 'Page\JsonController');
Route::any('/json/{param1}/{param2?}/{param3?}/{param4?}', 'App\Http\Controllers\Page\IndexController@jsonRoute');
Route::any('/{params?}', 'App\Http\Controllers\Page\IndexController@route')->where('params','.+');

//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
