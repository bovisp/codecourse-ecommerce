<?php

namespace App\Http\Controllers\Categories;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;

class CategoriesController extends Controller
{
    public function index()
    {
    	return CategoryResource::collection(
    		Category::with('children')->parents()->ordered()->get()
    	);
    }
}
