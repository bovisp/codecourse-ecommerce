<?php

namespace App\Http\Controllers\Addresses;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AddressResource;

class AddressController extends Controller
{
	public function __construct()
	{
		$this->middleware(['auth:api']);
	}

    public function index(Request $request)
    {
    	return AddressResource::collection(
    		$request->user()->addresses
    	);
    }
}
