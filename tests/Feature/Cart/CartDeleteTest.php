<?php

namespace Tests\Feature\Cart;

use Tests\TestCase;
use App\Models\User;
use App\Models\ProductVariation;

class CartDeleteTest extends TestCase
{
    public function test_it_fails_if_the_user_is_unauthenticated()
    {
    	$this->json('DELETE', 'api/cart/1')
        	->assertStatus(401);
    }

    public function test_it_fails_if_the_product_cant_be_found()
    {
    	$user = factory(User::class)->create();

    	$this->jsonAs($user, 'DELETE', 'api/cart/1')
        	->assertStatus(404);
    }

    public function test_it_deletes_the_product_from_the_cart()
    {
    	$user = factory(User::class)->create();

    	$user->cart()->attach(
    		$productVariation = factory(ProductVariation::class)->create(), [
    		'quantity' => $quantity = 1
    	]);

    	$response = $this->jsonAs($user, 'DELETE', "api/cart/{$productVariation->id}");

    	$this->assertDatabaseMissing('cart_user', [
            'product_variation_id' => $productVariation->id,
            'quantity' => $quantity
        ]);
    }
}
