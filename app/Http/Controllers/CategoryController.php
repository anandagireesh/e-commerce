<?php

namespace App\Http\Controllers;

use App\Interfaces\Interfaces\Category\CategoryInterface;
use App\Models\Category;
use App\Services\ApiResponseService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $apiResponseService;
    protected $categoryRepository;
    protected $categoryInterface;

    public function __construct(ApiResponseService $apiResponseService, CategoryInterface $categoryInterface)
    {
        $this->apiResponseService = $apiResponseService;
        $this->categoryInterface = $categoryInterface;
    }

    public function create(Request $request)
    {
        return $this->categoryInterface->storeCategory($request);
    }

    public function index(Request $request)
    {
        return $this->categoryInterface->getCategories($request->all());
    }

    public function update(Request $request, $category)
    {
        return $this->categoryInterface->updateCategory($request, $category);
    }

    public function destroy($category)
    {
        return $this->categoryInterface->deleteCategory($category);
    }
}
