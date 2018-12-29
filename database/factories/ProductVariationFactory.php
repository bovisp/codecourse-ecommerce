<?php

use App\Models\Product;
use Faker\Generator as Faker;
use App\Models\ProductVariation;
use App\Models\ProductVariationType;

$factory->define(ProductVariation::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->name,
        'product_id' => factory(Product::class)->create()->id,
        'product_variation_type_id' => factory(ProductVariationType::class)->create()->id
    ];
});
