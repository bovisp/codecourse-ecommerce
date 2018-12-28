<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use Tests\TestCase;

class ProductIndexTest extends TestCase
{
    public function test_it_shows_a_collection_of_products()
    {
        $products = factory(Product::class, 2)->create();

        $response = $this->json('GET', 'api/products');

        $products->each(function ($product) use ($response) {
        	$response->assertJsonFragment([
        		'slug' => $product->slug
        	]);
        });
    }

    public function test_it_has_paginated_data()
    {
        $this->json('GET', 'api/products')
        	->assertJsonStructure([
        		'data',
        		'links',
        		'meta'
        	]);
    }
}
