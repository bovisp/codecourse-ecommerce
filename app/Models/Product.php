<?php

namespace App\Models;

use App\Models\Category;
use App\Scoping\Scoper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function getRouteKeyName()
    {
    	return 'slug';
    }

    public function scopeWithScopes(Builder $builder, $scopes = [])
    {
    	return (new Scoper(request()))->apply($builder, $scopes);
    }

    public function categories()
    {
    	return $this->belongsToMany(Category::class);
    }
}
