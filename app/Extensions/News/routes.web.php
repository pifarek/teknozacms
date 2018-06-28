<?php

Route::group(['middleware' => 'auth.teknoza:administrator', 'prefix' => 'administrator'], function() {
    Route::group(['namespace' => 'App\Extensions\News\Controllers'], function() {

        Route::resource('news', 'IndexController', ['except' => ['show', 'destroy']]);

        Route::group(['prefix' => 'news'], function() {
            // Remove selected news
            Route::get('json/remove/{news_id}', 'JsonController@remove');

            // Upload news cover image
            Route::put('json/image-upload/{news_id}', 'JsonController@imageUpload');

            // Remove news cover image
            Route::get('json/image-remove/{news_id}', 'JsonController@imageRemove');

            // Categories
            Route::resource('categories', 'CategoriesController', ['except' => ['show', 'destroy']]);
            Route::group(['prefix' => 'categories'], function() {

                // Remove selected category
                Route::get('json/remove/{category_id}', 'JsonController@categoryRemove');
            });
        });
    });
});