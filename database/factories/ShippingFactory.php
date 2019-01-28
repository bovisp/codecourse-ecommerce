<?php

use App\Models\Shipping;
use Faker\Generator as Faker;

$factory->define(Shipping::class, function (Faker $faker) {
    return [
        'name' => 'US Mail',
        'price' => 1000
    ];
});
