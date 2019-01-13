<?php

namespace App\Http\Controllers\Cart;

use App\Cart\Cart;
use Illuminate\Http\Request;
use App\Models\ProductVariation;
use App\Http\Controllers\Controller;
use App\Http\Resources\Cart\CartResource;
use App\Http\Requests\Cart\CartStoreRequest;
use App\Http\Requests\Cart\CartUpdateRequest;

class CartController extends Controller
{
	public function __construct()
	{
		$this->middleware(['auth:api']);
	}

    public function index(Request $request, Cart $cart)
    {
        $request->user()->load([
            'cart.product', 'cart.product.variations.stock', 'cart.stock'
        ]);

        return (new CartResource($request->user()))
            ->additional([
                'meta' => $this->meta($cart)
            ]);
    }

    public function store(CartStoreRequest $request, Cart $cart)
    {
    	$cart->add($request->products);
    }

    public function update(ProductVariation $productVariation, CartUpdateRequest $request, Cart $cart)
    {
    	$cart->update($productVariation->id, $request->quantity);
    }

    public function destroy(ProductVariation $productVariation, Cart $cart)
    {
        $cart->delete($productVariation->id);
    }

    protected function meta(Cart $cart)
    {
        return [
            'empty' => $cart->isEmpty(),
            'subtotal' => $cart->subtotal()->formatted(),
            'total' => $cart->total()->formatted(),
        ];
    }
}
