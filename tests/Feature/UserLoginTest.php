<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserLoginTest extends TestCase
{
    public function test_user_login_success()
    {
        $response = $this->post('/api/user/login', [
            'email' => 'johndoe@gmail.com',
            'password' => 'Test@123'
        ]);

        $response->assertStatus(200);
    }

    public function test_user_login_failed()
    {
        $response = $this->post('/api/user/login', [
            'email' => 'johndode@gmail.com',
            'password' => 'Test@123'
        ]);

        $response->assertStatus(401);
    }

    public function test_user_login_validation_failed()
    {
        $response = $this->post('/api/user/login', [
            'email' => 'johndode@gmail.com'
        ]);

        $response->assertStatus(422);
    }
}
