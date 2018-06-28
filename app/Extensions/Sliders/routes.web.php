<?php

Route::group(['middleware' => 'auth.teknoza:administrator', 'prefix' => 'administrator'], function() {
    // Manage sliders
    Route::group(['namespace' => 'App\Extensions\Sliders\Controllers'], function() {

        Route::resource('sliders', 'IndexController', ['except' => ['show', 'destroy', 'edit']]);

        Route::group(['prefix' => 'sliders'], function() {

            // Remove selected slider
            Route::get('json/remove/{slider_id}', 'JsonController@remove');

            // Move selected slide
            Route::get('json/slide-move/{direction}/{slider_id}', 'JsonController@move');

            // Remove selected slide
            Route::get('json/slide-remove/{slide_id}', 'JsonController@slideRemove');

            // Upload temporary slide
            Route::post('json/image-tmp', 'JsonController@imageTmp');

            // Change image
            Route::put('json/image/{slide_id}', 'JsonController@image');

            // Slides
            Route::resource('slides', 'slidesController', ['except' => ['Index', 'show', 'destroy']]);
        });

    });
});