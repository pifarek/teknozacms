<?php

Route::group(['middleware' => 'auth.teknoza:administrator', 'prefix' => 'administrator'], function() {
    // Manage contacts
    Route::group(['namespace' => 'App\Extensions\Contacts\Controllers'], function() {

        Route::resource('contacts', 'IndexController', ['except' => ['show', 'destroy']]);

        Route::group(['prefix' => 'contacts'], function() {
            // Remove selected contact
            Route::get('json/remove/{contact_id}', 'JsonController@remove');
        });
    });
});