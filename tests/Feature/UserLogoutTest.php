<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UserLogoutTest extends TestCase
{
    public function test_user_logout_success()
    {
        $user = User::find(1);
        $token = $user->createToken('auth_token')->plainTextToken;
        $response = $this->post('/api/user/logout', [], ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);
    }

    public function test_user_logout_failed()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/user/logout');

        $response->assertStatus(401);
    }
}
