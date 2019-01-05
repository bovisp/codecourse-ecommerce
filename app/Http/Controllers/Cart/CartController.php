<?php

namespace App\Http\Controllers\Cart;

use App\Cart\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\CartStoreRequest;

class CartController extends Controller
{
	public function __construct()
	{
		$this->middleware(['auth:api']);
	}

    public function store(CartStoreRequest $request, Cart $cart)
    {
    	$cart->add($request->products);
    }
}
