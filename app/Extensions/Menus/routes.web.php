<?php

Route::group(['middleware' => 'auth.teknoza:administrator', 'prefix' => 'administrator'], function() {
    // Menu management
    Route::group(['prefix' => 'menus', 'namespace' => 'App\Extensions\Menus\Controllers'], function() {
        // Display all available menus
        Route::get('/', 'IndexController@menus');

        // Create a new menu
        Route::get('add', 'IndexController@getAdd');
        Route::post('add', 'IndexController@postAdd');

        // Edit a selected element
        Route::get('edit/{menu_id}', 'IndexController@getEdit');
        Route::post('edit/{menu_id}', 'IndexController@postEdit');

        // Remove selected menu
        Route::get('json/remove/{menu_id}', 'JsonController@remove');

        // Get the page shortcut
        Route::get('json/page-shortcut/{page}', 'JsonController@pageShortcut');

        // Upload cover image
        Route::post('json/item-intro-image/{item_id}', 'JsonController@postItemIntroImage');

        // Upload cover video
        Route::post('json/item-intro-video/{item_id}', 'JsonController@postItemIntroVideo');

        // Remove cover image
        Route::get('json/item-remove-intro-image/{item_id}', 'JsonController@getItemRemoveIntroImage');

        // Remove cover video
        Route::get('json/item-remove-intro-video/{item_id}', 'JsonController@getItemRemoveIntroVideo');

        // Menu Items management
        Route::group(['prefix' => 'items/{menu_id}'], function() {
            // Display list of menu items
            Route::get('/', 'IndexController@items');

            // Add a new menu item
            Route::get('add', 'IndexController@getItemAdd');
            Route::post('add', 'IndexController@postItemAdd');

            // Edit selected menu item
            Route::get('edit/{item_id}', 'IndexController@getItemEdit');
            Route::post('edit/{item_id}', 'IndexController@postItemEdit');

            // Remove selected menu item
            Route::get('json/remove/{item_id}', 'JsonController@itemRemove');

            // Move selected menu item
            Route::get('json/move/{direction}/{item_id}', 'JsonController@itemMove');
        });
    });
});