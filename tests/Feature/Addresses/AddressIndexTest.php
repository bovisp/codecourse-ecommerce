<?php

namespace Tests\Feature\Addresses;

use Tests\TestCase;
use App\Models\User;
use App\Models\Address;

class AddressIndexTest extends TestCase
{
    public function test_it_fails_if_unauthenticated()
    {
        $this->json('GET', 'api/addresses')
        	->assertStatus(401);
    }

    public function test_it_shows_addresses()
    {
    	$user = factory(User::class)->create();

    	$user->addresses()->save(
    		$address = factory(Address::class)->create([
    			'user_id' => $user->id
    		])
    	);

        $response = $this->jsonAS($user, 'GET', 'api/addresses')
		    ->assertJsonFragment([
		    	'id' => $address->id,
		    	'name' => $address->name,
		    	'address_1' => $address->address_1,
		    	'city' => $address->city,
		    	'postal_code' => $address->postal_code,
		    	'country' => [
		    		'id' => $address->country->id,
		    		'name' => $address->country->name,
		    		'code' => $address->country->code
		    	]
		    ]);
    }
}
