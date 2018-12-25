<?php

use App\Models\Category;

Route::get('/', function () {
	dd(Category::parents()->ordered()->get());
});