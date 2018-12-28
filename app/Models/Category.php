<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Product;
use App\Models\Traits\HasChildren;
use App\Models\Traits\Orderable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	use HasChildren, Orderable;

	protected $fillable = [
		'name',
		'slug',
		'order'
	];

	public function children()
    {
    	return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function products()
    {
    	return $this->belongsToMany(Product::class);
    }
}
