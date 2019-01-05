<?php

namespace Tests\Feature\Cart;

use Tests\TestCase;
use App\Models\User;
use App\Models\ProductVariation;

class CartStoreTest extends TestCase
{
    public function test_it_fails_if_unauthenticated()
    {
        $this->json('POST', 'api/cart')
        	->assertStatus(401);
    }

    public function test_it_requires_products()
    {
    	$user = factory(User::class)->create();

        $this->jsonAs($user, 'POST', 'api/cart')
        	->assertJsonValidationErrors(['products']);
    }

    public function test_it_requires_products_to_be_an_array()
    {
    	$user = factory(User::class)->create();

        $this->jsonAs($user, 'POST', 'api/cart', [
        	'products' => 1
        ])
        	->assertJsonValidationErrors(['products']);
    }

    public function test_it_requires_products_to_have_an_id()
    {
    	$user = factory(User::class)->create();

        $this->jsonAs($user, 'POST', 'api/cart', [
        	'products' => [
        		[ 'quantity' => 1 ]
        	]
        ])
        	->assertJsonValidationErrors(['products.0.id']);
    }

    public function test_it_requires_products_to_exist()
    {
    	$user = factory(User::class)->create();

        $this->jsonAs($user, 'POST', 'api/cart', [
        	'products' => [
        		[ 'id' => 1, 'quantity' => 1 ]
        	]
        ])
        	->assertJsonValidationErrors(['products.0.id']);
    }

    public function test_the_product_quantity_must_be_numeric()
    {
    	$user = factory(User::class)->create();

        $this->jsonAs($user, 'POST', 'api/cart', [
        	'products' => [
        		[ 'id' => 1, 'quantity' => 'nope' ]
        	]
        ])
        	->assertJsonValidationErrors(['products.0.quantity']);
    }

    public function test_the_product_quantity_must_be_at_least_one()
    {
    	$user = factory(User::class)->create();

        $this->jsonAs($user, 'POST', 'api/cart', [
        	'products' => [
        		[ 'id' => 1, 'quantity' => 0 ]
        	]
        ])
        	->assertJsonValidationErrors(['products.0.quantity']);
    }

    public function test_it_can_add_products_to_the_users_cart()
    {
    	$user = factory(User::class)->create();

    	$product = factory(ProductVariation::class)->create();

        $resonse = $this->jsonAs($user, 'POST', 'api/cart', [
        	'products' => [
        		[ 'id' => $product->id, 'quantity' => $quantity = 2 ]
        	]
        ]);
        	
    	$this->assertDatabaseHas('cart_user', [
    		'product_variation_id' => $product->id,
    		'quantity' => $quantity
    	]);
    }
}
