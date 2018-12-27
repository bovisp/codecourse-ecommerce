<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\PrivateUserResource;

class LoginController extends Controller
{
    public function store(LoginRequest $request)
    {
    	if (!$token = auth()->attempt($request->only('email', 'password'))) {
    		return response()->json([
    			'errors' => [
    				'email' => ['Could not sign you in with those details.']
    			]
    		], 422);
    	}

    	return (new PrivateUserResource($request->user()))
    		->additional([
    			'meta' => [
    				'token' => $token
    			]
    		]);
    }
}
