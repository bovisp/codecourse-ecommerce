<?php

namespace Tests\Feature\Countries;

use Tests\TestCase;
use App\Models\Country;

class CountriesIndexTest extends TestCase
{
    public function test_it_returns_countries()
    {
        $country = factory(Country::class)->create();

        $this->json('GET', 'api/countries')
        	->assertJsonFragment([
        		'name' => $country->name,
        		'code' => $country->code
        	]);
    }
}
