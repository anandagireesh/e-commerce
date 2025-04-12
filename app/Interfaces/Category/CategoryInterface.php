<?php

namespace App\Interfaces\Category;

interface CategoryInterface
{
    public function storeCategory($request);
    public function getCategories($filters);
    public function updateCategory($request, $category);
    public function deleteCategory($category);
}
