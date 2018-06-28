<?php

Route::group(['middleware' => 'auth.teknoza:administrator', 'prefix' => 'administrator'], function() {
    // Multimedia
    Route::group(['namespace' => 'App\Extensions\Multimedia\Controllers', 'prefix' => 'multimedia'], function() {

        // Display content of the album
        Route::get('/{album_id?}', 'IndexController@manage');

        // Upload temporary image
        Route::post('json/image-upload', 'jsonController@imageUpload');

        // Add a new multimedia item
        Route::post('json/add', 'jsonController@add');

        // Edit a multimedia item
        Route::post('json/edit/{multimedia_id}', 'jsonController@edit');

        // Get the multimedia item
        Route::get('json/multimedia/{multimedia_id}', 'jsonController@multimedia');

        // Change order of multimedia items
        Route::get('json/order', 'jsonController@order');

        // Remove multimedia item
        Route::get('json/multimedia-remove/{multimedia_id}', 'jsonController@multimediaRemove');

        // Add a new multimedia album
        Route::post('json/album-add', 'jsonController@albumAdd');

        // Get the multimedia album
        Route::get('json/album/{multimedia_id}', 'jsonController@album');

        // Edit the multimedia album
        Route::post('json/album-edit/{album_id}', 'jsonController@albumEdit');

        // Remove multimedia album
        Route::get('json/album-remove/{album_id}', 'jsonController@albumRemove');
    });
});