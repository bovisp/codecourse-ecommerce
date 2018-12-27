<?php

namespace Tests\Unit\Models\Users;

use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    public function test_it_hashes_the_password_when_creating()
    {
        $user = factory(User::class)->create([
        	'password' => 'cats'
        ]);

        $this->assertNotEquals($user->password, 'cats');
    }
}
