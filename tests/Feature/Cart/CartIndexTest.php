<?php

namespace Tests\Feature\Cart;

use Tests\TestCase;
use App\Models\User;
use App\Models\ProductVariation;

class CartIndexTest extends TestCase
{
    public function test_it_fails_if_the_user_is_unauthenticated()
    {
    	$this->json('GET', 'api/cart')
        	->assertStatus(401);
    }

    public function test_it_shows_products_in_the_users_cart()
    {
    	$user = factory(User::class)->create();

    	$user->cart()->save(
    		$product = factory(ProductVariation::class)->create()
    	);

    	$response = $this->jsonAs($user, 'GET', 'api/cart')
        	->assertJsonFragment([
        		'id' => $product->id
        	]);
    }

    public function test_it_shows_if_the_cart_is_empty()
    {
        $user = factory(User::class)->create();

        $response = $this->jsonAs($user, 'GET', 'api/cart')
            ->assertJsonFragment([
                'empty' => true
            ]);
    }

    public function test_it_shows_a_formatted_subtotal()
    {
        $user = factory(User::class)->create();

        $response = $this->jsonAs($user, 'GET', 'api/cart')
            ->assertJsonFragment([
                'subtotal' => '$0.00'
            ]);
    }

    public function test_it_shows_a_formatted_total()
    {
        $user = factory(User::class)->create();

        $response = $this->jsonAs($user, 'GET', 'api/cart')
            ->assertJsonFragment([
                'total' => '$0.00'
            ]);
    }

    public function test_it_syncs_the_cart()
    {
        $user = factory(User::class)->create();

        $user->cart()->attach(
            $productVariation = factory(ProductVariation::class)->create(), [
                'quantity' => 1
            ]
        );

        $response = $this->jsonAs($user, 'GET', 'api/cart')
            ->assertJsonFragment([
                'changed' => true
            ]);
    }
}
