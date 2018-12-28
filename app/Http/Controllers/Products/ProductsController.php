<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductIndexResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
    	$products = Product::paginate(10);

    	return ProductIndexResource::collection($products);
    }

    public function show(Product $product)
    {
    	return new ProductResource($product);
    }
}
