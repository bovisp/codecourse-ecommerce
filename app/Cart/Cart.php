<?php

namespace App\Cart;

use App\Models\User;

class Cart
{
	protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	public function add($products)
	{
		$this->user->cart()->syncWithoutDetaching(
    		$this->getStorePayload($products)
    	);
	}

	public function update($productId, $quantity)
	{
		$this->user->cart()->updateExistingPivot($productId, [
			'quantity' => $quantity
		]);
	}

	public function delete($productId)
	{
		$this->user->cart()->detach($productId);
	}

	protected function getStorePayload($products)
	{
		return collect($products)
    		->keyBy('id')
    		->map(function ($product) {
    			return [
    				'quantity' => $product['quantity'] + $this->getCurrentQuantity($product['id'])
    			];
    		})
    		->toArray();
	}

	protected function getCurrentQuantity($productId)
	{
		if ($product = $this->user->cart->where('id', $productId)->first()) {
			return $product->pivot->quantity;
		}

		return 0;
	}
}