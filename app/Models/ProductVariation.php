<?php

namespace App\Models;

use App\Models\Product;
use App\Models\ProductVariationType;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    public function type()
    {
    	return $this->hasOne(ProductVariationType::class, 'id', 'product_variation_type_id');
    }

    public function product()
    {
    	return $this->belongsTo(Product::class);
    }
}
