<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    // use RefreshDatabase;

    public function test_user_registration_with_valid_data()
    {
        Storage::fake('public');

        $profilePic = UploadedFile::fake()->image('profile.jpg', 100, 100)->size(100);

        $response = $this->postJson('/api/user/register', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe1@example.com',
            'password' => 'P@ssw0rd1',
            'password_confirmation' => 'P@ssw0rd1',
            'phone' => '+1234567890',
            'profile_pic' => $profilePic,
            'address_line_1' => '123 Main Street',
            'address_line_2' => 'Apt 4B',
            'city' => 'tvm',
            'state_id' => 1618,
            'country_id' => 100,
            'zip_code' => '10001',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['message', 'data' => ['id', 'first_name', 'email', 'token']]);

        $this->assertDatabaseHas('users', ['email' => 'johndoe@example.com']);
    }

    public function test_registration_fails_with_invalid_email()
    {
        $response = $this->postJson('/api/user/register', [
            'first_name' => 'John',
            'email' => 'invalid-email',
            'password' => 'P@ssw0rd1',
            'password_confirmation' => 'P@ssw0rd1',
            'phone' => '+1234567890',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_registration_fails_with_short_password()
    {
        $response = $this->postJson('/api/user/register', [
            'first_name' => 'John',
            'email' => 'johndoe@example.com',
            'password' => 'Short1!',
            'password_confirmation' => 'Short1!',
            'phone' => '+1234567890',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['password']);
    }

    public function test_registration_fails_with_invalid_phone()
    {
        $response = $this->postJson('/api/user/register', [
            'first_name' => 'John',
            'email' => 'johndoe@example.com',
            'password' => 'P@ssw0rd1',
            'password_confirmation' => 'P@ssw0rd1',
            'phone' => 'invalid-phone',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['phone']);
    }

    public function test_registration_fails_with_missing_fields()
    {
        $response = $this->postJson('/api/user/register', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['first_name', 'email', 'password', 'phone']);
    }

    public function test_user_cannot_register_with_duplicate_email()
    {
        // User::factory()->create(['email' => 'existing@example.com']);

        $response = $this->postJson('/api/user/register', [
            'first_name' => 'Jane',
            'email' => 'johndoe@example.com',
            'password' => 'P@ssw0rd1',
            'password_confirmation' => 'P@ssw0rd1',
            'phone' => '+1234567890',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
}
