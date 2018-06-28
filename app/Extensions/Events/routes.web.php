<?php

Route::group(['middleware' => 'auth.teknoza:administrator', 'prefix' => 'administrator'], function() {
    // Page events
    Route::group(['namespace' => 'App\Extensions\Events\Controllers'], function() {
        Route::resource('events', 'IndexController', ['except' => ['show', 'destroy']]);

        Route::group(['prefix' => 'events'], function() {
            // Upload event image
            Route::put('json/image/{event_id}', 'jsonController@image');

            // Remove event image
            Route::get('json/image-remove/{event_id}', 'jsonController@imageRemove');

            // Remove selected event
            Route::get('json/remove/{event_id}', 'jsonController@remove');
        });
    });
});