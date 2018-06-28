<?php

Route::group(['middleware' => 'auth.teknoza:administrator', 'prefix' => 'administrator'], function() {
    // Newsletter
    Route::group(['prefix' => 'newsletter', 'namespace' => 'App\Extensions\Newsletter\Controllers'], function() {

        // Newsletter send
        Route::group(['prefix' => 'send', 'namespace' => 'Send'], function() {
            // Select type of the newsletter
            Route::get('/', 'IndexController@Index');
            Route::post('/', 'IndexController@postIndex');

            // Compose greetings message
            Route::get('greetings', 'IndexController@composeGreetings');
            Route::post('greetings', 'IndexController@sendGreetings');

            // Compose content message
            Route::get('content', 'IndexController@composeContent');
            Route::post('content', 'IndexController@sendContent');
            // Store content elements
            Route::get('json/content-elements', 'jsonController@contentElements');


            // Compose empty message
            Route::get('empty', 'IndexController@composeEmpty');
            Route::post('empty', 'IndexController@sendEmpty');
        });

    });

    // Newsletter email
    Route::group(['namespace' => 'App\Extensions\Newsletter\Controllers'], function() {
        Route::resource('newsletter', 'IndexController', ['except' => ['show', 'destroy']]);

        Route::group(['prefix' => 'newsletter'], function(){
            // Remove selected newsletter user
            Route::get('json/remove/{newsletter_id}', 'jsonController@remove');
        });
    });

    // Newsletter groups
    Route::group(['namespace' => 'App\Extensions\Newsletter\Controllers', 'prefix' => 'newsletter'], function() {
        Route::resource('groups', 'GroupsController', ['except' => ['show', 'destroy']]);

        // Remove selected newsletter group
        Route::get('json/group-remove/{group_id}', 'jsonController@groupRemove');
    });
});