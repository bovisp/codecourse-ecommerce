<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use Tests\TestCase;

class ProductShowTest extends TestCase
{
    public function test_it_fails_if_a_product_cant_be_found()
    {
        $this->json('GET', 'api/products/nope')
        	->assertStatus(404);
    }

    public function test_it_shows_a_product()
    {
    	$product = factory(Product::class)->create();

        $this->json('GET', 'api/products/' . $product->slug)
        	->assertJsonFragment([
        		'slug' => $product->slug
        	]);
    }
}
