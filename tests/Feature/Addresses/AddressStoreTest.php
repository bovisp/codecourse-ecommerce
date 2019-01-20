<?php

namespace Tests\Feature\Addresses;

use Tests\TestCase;
use App\Models\User;
use App\Models\Address;
use App\Models\Country;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddressStoreTest extends TestCase
{
    public function test_it_fails_if_unauthenticated()
    {
        $this->json('POST', 'api/addresses')
        	->assertStatus(401);
    }

    public function test_it_requires_a_name()
    {
    	$user = factory(User::class)->create();

    	$this->jsonAs($user, 'POST', 'api/addresses')
        	->assertJsonValidationErrors([
        		'name'
        	]);
    }

    public function test_it_requires_an_address_line_one()
    {
    	$user = factory(User::class)->create();

    	$this->jsonAs($user, 'POST', 'api/addresses')
        	->assertJsonValidationErrors([
        		'address_1'
        	]);
    }

    public function test_it_requires_a_city()
    {
    	$user = factory(User::class)->create();

    	$this->jsonAs($user, 'POST', 'api/addresses')
        	->assertJsonValidationErrors([
        		'city'
        	]);
    }

    public function test_it_requires_a_postal_code()
    {
    	$user = factory(User::class)->create();

    	$this->jsonAs($user, 'POST', 'api/addresses')
        	->assertJsonValidationErrors([
        		'postal_code'
        	]);
    }

    public function test_it_requires_a_country_id()
    {
    	$user = factory(User::class)->create();

    	$this->jsonAs($user, 'POST', 'api/addresses')
        	->assertJsonValidationErrors([
        		'country_id'
        	]);
    }

    public function test_it_requires_a_country_id_to_exist()
    {
    	$user = factory(User::class)->create();

    	$this->jsonAs($user, 'POST', 'api/addresses', [
    		'country_id' => 999999
    	])
        	->assertJsonValidationErrors([
        		'country_id'
        	]);
    }

    public function test_it_stores_an_address()
    {
    	$user = factory(User::class)->create();

    	$country = factory(Country::class)->create();

    	$response = $this->jsonAs($user, 'POST', 'api/addresses', $payload = [
    		'country_id' => $country->id,
    		'name' => 'Paul Bovis',
    		'address_1' => '123 4 Street',
    		'city' => 'Geopololis',
    		'postal_code' => '12345'
    	]);

    	$this->assertDatabaseHas('addresses', array_merge($payload, [
    		'user_id' => $user->id
    	]));
    }

    public function test_it_returns_an_address()
    {
    	$user = factory(User::class)->create();

    	$country = factory(Country::class)->create();

    	$response = $this->jsonAs($user, 'POST', 'api/addresses', $payload = [
    		'country_id' => $country->id,
    		'name' => 'Paul Bovis',
    		'address_1' => '123 4 Street',
    		'city' => 'Geopololis',
    		'postal_code' => '12345'
    	]);
	    	
	    $response->assertJsonFragment([
	    	'id' => json_decode($response->getContent())->data->id
	    ]);
    }
}