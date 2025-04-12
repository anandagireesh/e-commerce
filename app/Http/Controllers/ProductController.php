<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Interfaces\ProductInterface;
use App\Services\ApiResponseService;
use Illuminate\Http\Request;
use App\Http\Resources\Product\ProductResourceCollection;

class ProductController extends Controller
{
    public $productInterface;
    public $apiResponseService;
    public function __construct(ProductInterface $productInterface, ApiResponseService $apiResponseService)
    {
        $this->productInterface = $productInterface;
        $this->apiResponseService = $apiResponseService;
    }


    public function create(Request $request)
    {
        try {
            $this->productInterface->storeProduct($request);
            return $this->apiResponseService->success('Product created successfully', 200);
        } catch (\Exception $e) {
            return $this->apiResponseService->error($e->getMessage(), 500);
        }
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

        $products = $this->productInterface->getProducts($filters);

        return $this->apiResponseService->success(
            'Products fetched successfully',
            $products['data'],
            200,
            [
                'pagination' => $products['pagination']
            ]
        );
    }
}
