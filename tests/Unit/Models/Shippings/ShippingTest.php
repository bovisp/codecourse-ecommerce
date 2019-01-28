<?php

namespace Tests\Unit\Models\Shippings;

use App\Cart\Money;
use Tests\TestCase;
use App\Models\Shipping;

class ShippingTest extends TestCase
{
    public function test_it_returns_a_money_instance_for_the_price()
    {
        $shipping = factory(Shipping::class)->create();

        $this->assertInstanceOf(Money::class, $shipping->price);
    }

    public function test_it_returns_a_formatted_price()
    {
        $shipping = factory(Shipping::class)->create([
        	'price' => 0
        ]);

        $this->assertEquals($shipping->formattedPrice, '$0.00');
    }
}
