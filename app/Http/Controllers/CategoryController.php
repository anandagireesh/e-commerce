<?php

namespace App\Http\Controllers;

use App\Interfaces\Category\CategoryInterface;
use App\Services\ApiResponseService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $apiResponseService;
    protected $categoryInterface;

    public function __construct(ApiResponseService $apiResponseService, CategoryInterface $categoryInterface)
    {
        $this->apiResponseService = $apiResponseService;
        $this->categoryInterface = $categoryInterface;
    }

    public function create(Request $request)
    {
        $this->categoryInterface->storeCategory($request);
        return $this->apiResponseService->success('Category created successfully', 200);
    }

    public function index(Request $request)
    {
        $categories = $this->categoryInterface->getCategories($request->all());
        return $this->apiResponseService->success('Categories fetched successfully', $categories['data'], 200, [
            'pagination' => $categories['pagination']
        ]);
    }

    public function update(Request $request, $category)
    {
        $this->categoryInterface->updateCategory($request, $category);
        return $this->apiResponseService->success('Category updated successfully', 200);
    }

    public function destroy($category)
    {
        $this->categoryInterface->deleteCategory($category);

        return $this->apiResponseService->success('Category deleted successfully', 200);
    }
}
