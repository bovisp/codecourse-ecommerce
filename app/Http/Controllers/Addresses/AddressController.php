<?php

namespace App\Http\Controllers\Addresses;

use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AddressResource;
use App\Http\Requests\Addresses\AddressStoreRequest;

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

    public function store(AddressStoreRequest $request)
    {
        $address = Address::make($request->only([
            'name', 'address_1', 'city', 'postal_code', 'country_id', 'default'
        ]));

        $request->user()->addresses()->save($address);

        return new AddressResource($address);
    }
}
