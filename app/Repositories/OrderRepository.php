<?php

namespace App\Repositories;

use App\Http\Resources\Order\OrderResource;
use App\Http\Resources\Order\OrderResourceCollection;
use App\Interfaces\OrderInterface;
use App\Models\Order;
use App\Services\ApiResponseService;

class OrderRepository implements OrderInterface
{
    /**
     * Create a new class instance.
     */
    protected $apiResponseService;
    public function __construct(ApiResponseService $apiResponseService)
    {
        $this->apiResponseService = $apiResponseService;
    }

    public function create($data)
    {
        $data['user_id'] = auth()->user()->id;
        $data = $this->calculateOrderTotal($data);
        $orderData = $data->only(['total_price', 'shipping_cost', 'discount', 'grand_total', 'payment_method', 'payment_status', 'order_status', 'order_date', 'order_address', 'user_id']);
        $order = Order::create($orderData);
        $this->updateInventory($data);
        $data = $this->createOrderItems($data);
        $order->items()->createMany($data->items);

        return $order;
    }

    public function calculateOrderTotal($data)
    {

        $productIds = collect($data->items)->pluck('product_id')->toArray();
        $products = \App\Models\Product::whereIn('id', $productIds)->get()->keyBy('id');

        $totalPrice = collect($data->items)->sum(function ($item) use ($products) {
            $product = $products->get($item['product_id']);
            return $product ? $product->price * $item['quantity'] : 0;
        });
        $data['total_price'] = $totalPrice;
        $totalPrice = $data->total_price;
        $shippingCost = $data->shipping_cost;
        $discount = $data->discount;
        $grandTotal = $totalPrice + ($shippingCost - $discount);
        $data['grand_total'] = $grandTotal;
        return $data;
    }

    public function createOrderItems($data)
    {
        $orderItems = [];
        $productIds = collect($data->items)->pluck('product_id')->toArray();
        $products = \App\Models\Product::whereIn('id', $productIds)->get()->keyBy('id');
        foreach ($data->items as $item) {
            $product = $products->get($item['product_id']);
            $orderItems[] = [
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $product->price,
                'total_price' => $product->price * $item['quantity'],
            ];
        }
        $data['items'] = $orderItems;
        return $data;
    }

    public function updateInventory($order)
    {
        $productIds = collect($order->items)->pluck('product_id')->toArray();
        $products = \App\Models\Product::whereIn('id', $productIds)->get()->keyBy('id');

        foreach ($order->items as $item) {
            $product = $products->get($item['product_id']);
            if ($product) {
                if ($order->order_status === 'cancelled') {
                    $product->stock = $product->stock + $item['quantity'];
                } else if ($order->order_status === 'pending') {
                    $product->stock = $product->stock - $item['quantity'];
                }
                $product->save();
            }
        }
    }

    public function index($filters)
    {
        $orders = Order::with('items');
        if (!empty($filters['sort_by'])) {
            $orders->orderBy($filters['sort_by'], $filters['sort_direction']);
        }
        if (auth()->check() && auth()->user()->hasRole('Customer')) {
            $orders->where('user_id', auth()->user()->id);
        }
        $orders = $orders->paginate($filters['per_page'], ['*'], 'page', $filters['page']);
        $resourceCollection = new OrderResourceCollection($orders);
        return [
            'data' => $resourceCollection->collection,
            'pagination' => [
                'total' => $orders->total(),
                'per_page' => $orders->perPage(),
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
                'from' => $orders->firstItem(),
                'to' => $orders->lastItem(),
            ],
        ];
    }

    public function show($order)
    {
        $order = Order::findByHashid($order);
        $order->load('items');
        return new OrderResource($order);
    }

    public function update($order, $request)
    {
        $order = Order::findByHashid($order);
        $data = [];
        if ($request->order_status) {
            $data['order_status'] = $request->order_status;
        }
        if ($request->payment_status) {
            $data['payment_status'] = $request->payment_status;
        }
        $order->update($data);
        return $order;
    }

    public function cancel($order)
    {
        $order = Order::findByHashid($order);
        $order->update(['order_status' => 'cancelled']);
        $this->updateInventory($order);
        return $order;
    }
}
