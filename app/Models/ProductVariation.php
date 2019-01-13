<?php

namespace App\Models;

use App\Cart\Money;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Traits\HasPrice;
use App\Models\ProductVariation;
use App\Models\ProductVariationType;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
	use HasPrice;

	public function getPriceAttribute($value)
    {
    	if ($value === null) {
    		return $this->product->price;
    	}
        return new Money($value);
    }

    public function priceVaries()
    {
    	return $this->price->amount() !== $this->product->price->amount();
    }

    public function inStock()
    {
        return $this->stockCount() > 0;
    }

    public function stockCount()
    {
        return $this->stock->sum('pivot.stock');
    }

    public function type()
    {
    	return $this->hasOne(ProductVariationType::class, 'id', 'product_variation_type_id');
    }

    public function product()
    {
    	return $this->belongsTo(Product::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function stock()
    {
        return $this->belongsToMany(
            ProductVariation::class, 'product_variation_stock_view'
        )
            ->withPivot([
                'stock',
                'in_stock'
            ]);   
    }

    public function minStock($count)
    {
        return min($this->stockCount(), $count);
    }
}
