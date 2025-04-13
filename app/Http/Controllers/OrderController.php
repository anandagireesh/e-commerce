<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\OrderInterface;
use App\Services\ApiResponseService;

class OrderController extends Controller
{
    protected $orderInterface;
    protected $apiResponseService;

    public function __construct(OrderInterface $orderInterface, ApiResponseService $apiResponseService)
    {
        $this->orderInterface = $orderInterface;
        $this->apiResponseService = $apiResponseService;
    }

    public function create(Request $request)
    {
        $order = $this->orderInterface->create($request);
        return $this->apiResponseService->success(
            'Order created successfully',
            $order,
            200
        );
    }

    public function index(Request $request)
    {
        $filters = [
            'search' => $request->input('search'),
            'sort_by' => $request->input('sort_by', 'created_at'),
            'sort_direction' => $request->input('sort_direction', 'desc'),
            'per_page' => $request->input('per_page', 15),
            'page' => $request->input('page', 1),
        ];
        $orders = $this->orderInterface->index($filters);
        return $this->apiResponseService->success(
            'Orders fetched successfully',
            $orders['data'],
            200,
            [
                'pagination' => $orders['pagination']
            ],
            200
        );
    }

    public function show(Request $request, $order)
    {
        $order = $this->orderInterface->show($order);
        if (!$order) {
            return $this->apiResponseService->error(
                'Order not found',
                404
            );
        }
        if (auth()->check() && auth()->user()->hasRole('Customer')) {
            if ($order->user_id !== auth()->user()->id) {
                return $this->apiResponseService->error(
                    'Unauthorized',
                    403
                );
            }
        }
        return $this->apiResponseService->success(
            'Order fetched successfully',
            $order,
            200
        );
    }

    public function update(Request $request, $order)
    {
        $order = $this->orderInterface->update($order, $request);
        return $this->apiResponseService->success(
            'Order updated successfully',
            $order,
            200
        );
    }

    public function cancel(Request $request, $order)
    {
        $order = $this->orderInterface->cancel($order, $request);
        return $this->apiResponseService->success(
            'Order cancelled successfully',
            $order,
            200
        );
    }
}
