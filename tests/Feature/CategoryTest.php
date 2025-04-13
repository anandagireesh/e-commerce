<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    public function test_user_can_create_category()
    {
        $user = User::find(1);
        $token = $user->createToken('auth_token')->plainTextToken;
        $categoryData = [
            'name' => 'Test Category 4',
        ];
        $response = $this->post('/api/category/create', $categoryData, ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);
    }

    public function test_user_can_update_category()
    {
        $user = User::find(1);
        $token = $user->createToken('auth_token')->plainTextToken;
        $categoryData = [
            'name' => 'Test Category 2 Updated',
        ];
        $category = Category::find(3);

        $hashId = $category->hashid;
        $response = $this->put('/api/category/update/' . $hashId, $categoryData, ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);
    }

    public function test_user_can_delete_category()
    {
        $user = User::find(1);
        $token = $user->createToken('auth_token')->plainTextToken;
        $category = Category::find(3);
        $hashId = $category->hashid;
        $response = $this->delete('/api/category/delete/' . $hashId, [], ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);
    }

    public function test_user_can_get_category_list()
    {
        $user = User::find(1);
        $token = $user->createToken('auth_token')->plainTextToken;
        $response = $this->get('/api/category/list', [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json'
        ]);
        $response->assertStatus(200);
    }
}
