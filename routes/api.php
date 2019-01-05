<?php

Route::resource('categories', 'Categories\CategoriesController');

Route::resource('products', 'Products\ProductsController');

Route::resource('cart', 'Cart\CartController');

Route::group([ 'prefix' => 'auth'], function () {
	Route::post('register', 'Auth\\RegisterController@store');

	Route::post('login', 'Auth\\LoginController@store');

	Route::get('me', 'Auth\\MeController@show');
});