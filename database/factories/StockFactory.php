<?php

use App\Models\Stock;
use Faker\Generator as Faker;
use App\Models\ProductVariation;

$factory->define(Stock::class, function (Faker $faker) {
    return [
        'quantity' => 1
    ];
});
