<?php

namespace Tests\Feature\Cart;

use Tests\TestCase;
use App\Models\User;
use App\Models\ProductVariation;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartUpdateTest extends TestCase
{
	public function test_it_fails_if_the_user_is_unauthenticated()
    {
    	$this->json('PATCH', 'api/cart/1')
        	->assertStatus(401);
    }

    public function test_it_fails_if_the_product_cant_be_found()
    {
    	$user = factory(User::class)->create();

    	$this->jsonAs($user, 'PATCH', 'api/cart/1')
        	->assertStatus(404);
    }

    public function test_the_product_quantity_is_required()
    {
    	$user = factory(User::class)->create();

    	$productVariation = factory(ProductVariation::class)->create();

        $this->jsonAs($user, 'PATCH', "api/cart/{$productVariation->id}")
        	->assertJsonValidationErrors(['quantity']);
    }

    public function test_the_product_quantity_must_be_numeric()
    {
    	$user = factory(User::class)->create();

    	$productVariation = factory(ProductVariation::class)->create();

        $this->jsonAs($user, 'PATCH', "api/cart/{$productVariation->id}", [
        	'quantity' => 'nope'
        ])
        	->assertJsonValidationErrors(['quantity']);
    }

    public function test_the_product_quantity_must_be_greater_than_zero()
    {
    	$user = factory(User::class)->create();

    	$productVariation = factory(ProductVariation::class)->create();

        $this->jsonAs($user, 'PATCH', "api/cart/{$productVariation->id}", [
        	'quantity' => 0
        ])
        	->assertJsonValidationErrors(['quantity']);
    }

    public function test_the_product_quantity_can_be_updated()
    {
    	$user = factory(User::class)->create();

    	$user->cart()->attach(
    		$productVariation = factory(ProductVariation::class)->create(), [
    			'quantity' => 2
    		]
    	);

    	$request = $this->jsonAs($user, 'PATCH', "api/cart/{$productVariation->id}", [
        	'quantity' => $quantity = 2
        ]);
        	
        $this->assertDatabaseHas('cart_user', [
    		'product_variation_id' => $productVariation->id,
    		'quantity' => $quantity
    	]);
    }
}
