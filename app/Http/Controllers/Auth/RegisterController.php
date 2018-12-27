<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\PrivateUserResource;

class RegisterController extends Controller
{
    public function store(RegisterRequest $request)
    {
    	$user = User::create(
    		$request->only('email', 'name', 'password')
    	);

    	return new PrivateUserResource($user);
    }
}
