<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Traits\HasPrice;
use App\Models\ProductVariation;
use App\Models\Traits\CanBeScoped;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use CanBeScoped, HasPrice;

    public function getRouteKeyName()
    {
    	return 'slug';
    }

    public function inStock()
    {
        return $this->stockCount() > 0;
    }

    public function stockCount()
    {
        return $this->variations->sum(function ($variation) {
            return $variation->stockCount();
        });
    }

    public function categories()
    {
    	return $this->belongsToMany(Category::class);
    }

    public function variations()
    {   
       return $this->hasMany(ProductVariation::class)
        ->orderBy('order', 'asc'); 
    }
}
