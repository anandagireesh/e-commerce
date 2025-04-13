<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    public function test_create_order()
    {
        $user = User::find(1);
        $token = $user->createToken('auth_token')->plainTextToken;
        $response = $this->post('/api/order/create', [
            'items' => [
                ['product_id' => 1, 'quantity' => 1],
            ],
            'shipping_cost' => 10,
            'discount' => 0,
            'payment_method' => 'cash',
            'payment_status' => 'pending',
            'order_status' => 'pending',
            'order_date' => now(),
            'order_address' => 1,
        ], ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(200);
    }

    public function test_get_order_list()
    {
        $user = User::find(1);
        $token = $user->createToken('auth_token')->plainTextToken;
        $response = $this->get('/api/order/list', ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);
    }

    public function test_get_order_detail()
    {
        $user = User::find(1);
        $token = $user->createToken('auth_token')->plainTextToken;
        $order = Order::find(1);
        $hashId = $order->hashid;
        $response = $this->get('/api/order/detail/' . $hashId, ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);
    }

    public function test_update_order()
    {
        $user = User::find(1);
        $token = $user->createToken('auth_token')->plainTextToken;
        $order = Order::find(1);
        $hashId = $order->hashid;
        $response = $this->put('/api/order/update/' . $hashId, [
            'order_status' => 'cancelled',
        ], ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);
    }

    public function test_cancel_order()
    {
        $user = User::find(1);
        $token = $user->createToken('auth_token')->plainTextToken;
        $order = Order::find(1);
        $hashId = $order->hashid;
        $response = $this->post('/api/order/cancel/' . $hashId, [], ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);
    }
}
