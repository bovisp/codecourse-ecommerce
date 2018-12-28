<?php

use App\Models\Product;
use App\Models\ProductVariation;
use Faker\Generator as Faker;

$factory->define(ProductVariation::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->name,
        'product_id' => factory(Product::class)->create()->id
    ];
});
