<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Orderable
{
	public function scopeOrdered(Builder $builder, $direction = 'asc')
	{
		return $builder->orderBy('order', $direction);
	}
}