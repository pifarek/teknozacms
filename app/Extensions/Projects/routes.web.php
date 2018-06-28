<?php

Route::group(['middleware' => 'auth.teknoza:administrator', 'prefix' => 'administrator'], function() {
    // Page Projects
    Route::group(['namespace' => 'App\Extensions\Projects\Controllers'], function() {

        Route::resource('projects', 'IndexController', ['except' => ['show', 'destroy']]);

        Route::group(['prefix' => 'projects'], function() {

            // Remove selected project
            Route::get('json/remove/{project_id}', 'jsonController@remove');

            // Upload cover image
            Route::put('json/cover/{project_id}', 'jsonController@cover');

            // Remove cover image
            Route::get('json/cover-remove/{event_id}', 'jsonController@coverRemove');

            // Upload project image
            Route::put('json/image/{project_id}', 'jsonController@image');

            // Remove cover image
            Route::get('json/image-remove/{event_id}', 'jsonController@imageRemove');

            // Tags
            Route::resource('tags', 'TagsController', ['except' => ['show', 'destroy']]);

            Route::group(['prefix' => 'tags'], function() {
                // Remove selected tag
                Route::get('json/remove/{tag_id}', 'jsonController@tagRemove');
            });
        });
    });
});