<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;

class RegistrationTest extends TestCase
{
    public function test_it_requires_a_name()
    {
        $this->json('POST', 'api/auth/register')
        	->assertJsonValidationErrors(['name']);
    }

    public function test_it_requires_an_email()
    {
        $this->json('POST', 'api/auth/register')
        	->assertJsonValidationErrors(['email']);
    }

    public function test_it_requires_a_valid_email()
    {
        $this->json('POST', 'api/auth/register', [
        	'email' => 'notanemail'
        ])
        	->assertJsonValidationErrors(['email']);
    }

    public function test_it_requires_a_unique_email()
    {
    	$user = factory(User::class)->create();

        $this->json('POST', 'api/auth/register', [
        	'email' => $user->email
        ])
        	->assertJsonValidationErrors(['email']);
    }

    public function test_it_requires_a_password()
    {
        $this->json('POST', 'api/auth/register')
        	->assertJsonValidationErrors(['password']);
    }

    public function test_it_registers_a_user()
    {
        $this->json('POST', 'api/auth/register', [
        	'name' => $name = 'Paul Bovis',
        	'email' => $email = 'bovisp@me.com',
        	'password' => 'secret'
        ]);

        $this->assertDatabaseHas('users', [
        	'email' => $email,
        	'name' => $name
        ]);
    }

    public function test_it_returns_a_user_on_registration()
    {
        $this->json('POST', 'api/auth/register', [
        	'name' => 'Vida Bovis',
        	'email' => $email = 'bovisv@me.com',
        	'password' => 'secret'
        ])
	    	->assertJsonFragment([
	        	'email' => $email
	        ]);
    }
}
