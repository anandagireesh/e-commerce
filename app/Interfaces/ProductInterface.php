<?php

namespace App\Interfaces;

interface ProductInterface
{
    public function getProducts($filters);
    public function storeProduct($request);
}
