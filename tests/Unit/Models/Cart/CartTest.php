<?php

namespace Tests\Unit\Models\Cart;

use App\Cart\Cart;
use Tests\TestCase;
use App\Models\User;
use App\Models\ProductVariation;

class CartTest extends TestCase
{
    public function test_it_can_add_products_to_the_cart()
    {
        $cart = new Cart(
        	$user = factory(User::class)->create()
        );

        $product = factory(ProductVariation::class)->create();

        $cart->add([
        	[ 'id' => $product->id, 'quantity' => 1 ]
        ]);

        $this->assertCount(1, $user->fresh()->cart);
    }
}
