<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function test_user_can_create_product()
    {
        $user = User::find(1);
        $token = $user->createToken('auth_token')->plainTextToken;
        $productData = [
            'name' => 'Test Product',
            'description' => 'This is a test product',
            'price' => 99.99,
            'stock' => 100,
            'category_id' => [1],
            'is_primary' => 0,
            'images' => [
                UploadedFile::fake()->image('product1.jpg', 100, 100)->size(100),
                UploadedFile::fake()->image('product2.jpg', 100, 100)->size(100)
            ]
        ];
        $response = $this->post('/api/product/create', $productData, ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);
    }

    public function test_user_can_update_product()
    {
        $user = User::find(1);
        $token = $user->createToken('auth_token')->plainTextToken;
        $productData = [
            'name' => 'Test Product',
            'description' => 'This is a test product',
            'price' => 99.99,
            'stock' => 100,
        ];
        $product = Product::find(3);
        $hashId = $product->hashid;
        $response = $this->put('/api/product/update/' . $hashId, $productData, ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);
    }

    public function test_user_can_delete_product()
    {
        $user = User::find(1);
        $token = $user->createToken('auth_token')->plainTextToken;
        $product = Product::find(3);
        $hashId = $product->hashid;
        $response = $this->delete('/api/product/delete/' . $hashId, [], ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);
    }

    public function test_user_can_get_product_list()
    {
        $user = User::find(1);
        $token = $user->createToken('auth_token')->plainTextToken;
        $response = $this->get('/api/product/list', ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);
    }

    public function test_user_can_get_product()
    {
        $user = User::find(1);
        $token = $user->createToken('auth_token')->plainTextToken;
        $product = Product::find(1);
        $hashId = $product->hashid;
        $response = $this->get('/api/product/detail/' . $hashId, ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);
    }
}
