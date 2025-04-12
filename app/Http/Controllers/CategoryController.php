<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CreateCategory;
use App\Models\Category;
use App\Services\ApiResponseService;
use Illuminate\Http\Request;
use App\Repositories\Category\CategoryRepository;

class CategoryController extends Controller
{
    protected $apiResponseService;
    protected $categoryRepository;

    public function __construct(ApiResponseService $apiResponseService, CategoryRepository $categoryRepository)
    {
        $this->apiResponseService = $apiResponseService;
        $this->categoryRepository = $categoryRepository;
    }
    public function create(CreateCategory $request)
    {
        $category = $this->categoryRepository->storeCategory($request);
        return $this->apiResponseService->success('Category created successfully', $category);
    }

    public function index()
    {
        $filters = request()->all();
        $categories = $this->categoryRepository->getCategories($filters);
        return $this->apiResponseService->success(
            'Categories fetched successfully',
            $categories['data'],
            200,
            [
                'pagination' => $categories['pagination']
            ]
        );
    }

    public function update(CreateCategory $request, Category $category)
    {
        $category = $this->categoryRepository->updateCategory($request, $category);
        return $this->apiResponseService->success('Category updated successfully', $category);
    }

    public function destroy(Category $category)
    {
        $category = $this->categoryRepository->deleteCategory($category);
        return $this->apiResponseService->success('Category deleted successfully', $category);
    }
}
