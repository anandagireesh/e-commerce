<?php

namespace App\Interfaces;

interface ProductInterface
{
    public function getProducts($filters);
    public function storeProduct($request);
    public function updateProduct($request, $product);
    public function deleteProduct($product);
    public function updateStock($request, $product);
    public function getProduct($product);
}
