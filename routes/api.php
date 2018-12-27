<?php

Route::resource('categories', 'Categories\CategoriesController');

Route::group([ 'prefix' => 'auth'], function () {
	Route::post('register', 'Auth\\RegisterController@store');
});