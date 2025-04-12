<?php

namespace App\Repositories\Category;

use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Category\CategoryResourceCollection;
use App\Interfaces\Category\CategoryInterface;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryRepository implements CategoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function storeCategory($request)
    {
        $data = $request->only(['name']);
        $data['slug'] = Str::slug($data['name']);
        $category = Category::create($data);
        return new CategoryResource($category);
    }

    public function getCategories($filters)
    {
        $perPage = $filters['per_page'] ?? 10;
        $page = $filters['page'] ?? null;
        $categories = Category::query();
        if (!empty($filters['search'])) {
            $categories->where('name', 'like', '%' . $filters['search'] . '%');
        }
        if (!empty($filters['sort_by'])) {
            $categories->orderBy($filters['sort_by'], $filters['sort_direction']);
        }
        $categories = $categories->paginate($perPage, ['*'], 'page', $page);
        $resourceCollection = new CategoryResourceCollection($categories);
        return [
            'data' => $resourceCollection->collection,
            'pagination' => [
                'total' => $categories->total(),
                'per_page' => $categories->perPage(),
                'current_page' => $categories->currentPage(),
                'last_page' => $categories->lastPage(),
                'from' => $categories->firstItem(),
                'to' => $categories->lastItem()
            ]
        ];
    }

    public function updateCategory($request, $category)
    {
        $category->update($request->only(['name']));
        return new CategoryResource($category);
    }

    public function deleteCategory($category)
    {
        $category->delete();
        return new CategoryResource($category);
    }
}
