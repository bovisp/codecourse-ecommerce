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

    public function test_it_increases_quantity_when_adding_more_products()
    {
        $product = factory(ProductVariation::class)->create();

        $cart = new Cart(
            $user = factory(User::class)->create()
        );

        $cart->add([
            [ 'id' =>  $product->id, 'quantity' => 1 ]
        ]);

        $cart = new Cart($user->fresh());

        $cart->add([
            [ 'id' => $product->id, 'quantity' => 1 ]
        ]);

        $this->assertEquals(2, $user->fresh()->cart->first()->pivot->quantity);
    }

    public function test_it_can_update_quantities_in_the_cart()
    {
        $cart = new Cart(
            $user = factory(User::class)->create()
        );

        $product = factory(ProductVariation::class)->create();

        $cart->add([
            [ 'id' =>  $product->id, 'quantity' => 1 ]
        ]);

        $cart = new Cart($user->fresh());

        $cart->update($product->id, $quantity = 2);

        $this->assertEquals($quantity, $user->fresh()->cart->first()->pivot->quantity);
    }
}
