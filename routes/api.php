<?php

Route::group(['prefix' => '/v1/auth', 'namespace' => 'Api\Auth', 'as' => 'api'], function () {
    Route::post('register','AuthController@register');
    Route::post('login','AuthController@login');
    Route::post('refresh','AuthController@refresh');
});

Route::group(['prefix' => '/v1', 'namespace' => 'Api', 'as' => 'api.'], function () {
    Route::get('/getCategories', 'CategoryController@getCategories');
    Route::post('/getSongsByCategory', 'SongController@getSongsByCategory');
    Route::post('/upFavourite', 'SongController@upFavourite');
    Route::get('/hop', 'SongController@hop');
});

