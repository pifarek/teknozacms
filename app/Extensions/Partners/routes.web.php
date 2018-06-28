<?php

Route::group(['middleware' => 'auth.teknoza:administrator', 'prefix' => 'administrator'], function() {
    // Page Partners
    Route::group(['namespace' => 'App\Extensions\Partners\Controllers'], function() {

        Route::resource('partners', 'IndexController', ['except' => ['show', 'destroy']]);

        Route::group(['prefix' => 'partners'], function() {

            // Remove selected partner
            Route::get('json/remove/{partner_id}', 'jsonController@remove');

            // Change order
            Route::get('json/move/{direction}/{partner_id}', 'jsonController@move');

            // Upload partner image
            Route::put('json/image-upload/{event_id}', 'jsonController@imageUpload');

            // Remove partner image
            Route::get('json/image-remove/{event_id}', 'jsonController@imageRemove');
        });
    });
});