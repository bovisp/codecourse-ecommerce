<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{
	protected $fillable = [
		'name',
		'slug',
		'order'
	];

	public function scopeParents(Builder $builder)
	{
		return $builder->whereNull('parent_id');
	}

	public function scopeOrdered(Builder $builder, $direction = 'asc')
	{
		return $builder->orderBy('order', $direction);
	}

    public function children()
    {
    	return $this->hasMany(Category::class, 'parent_id', 'id');
    }
}
