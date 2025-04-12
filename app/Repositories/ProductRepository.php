<?php

namespace App\Repositories;

use App\Http\Resources\Product\ProductResourceCollection;
use App\Interfaces\ProductInterface;
use App\Models\Product;
use App\Services\ImageHandleService;
use Illuminate\Support\Str;

class ProductRepository implements ProductInterface
{
    /**
     * Create a new class instance.
     */
    public $imageHandleService;
    public function __construct(ImageHandleService $imageHandleService)
    {
        $this->imageHandleService = $imageHandleService;
    }

    public function getProducts($filters)
    {
        $perPage = $filters['per_page'] ?? 10;
        $page = $filters['page'] ?? null;

        $products = Product::with('images');
        if (!empty($filters['search'])) {
            $products->where('name', 'like', '%' . $filters['search'] . '%');
        }
        if (!empty($filters['sort_by'])) {
            $products->orderBy($filters['sort_by'], $filters['sort_direction']);
        }
        // if (!empty($filters['per_page']) || !empty($filters['page'])) {
        //     $products->paginate($filters['per_page'], ['*'], 'page', $filters['page']);
        // }
        $products = $products->paginate($perPage, ['*'], 'page', $page);
        $resourceCollection = new ProductResourceCollection($products);
        return [
            'data' => $resourceCollection->collection,
            'pagination' => [
                'total' => $products->total(),
                'per_page' => $products->perPage(),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'from' => $products->firstItem(),
                'to' => $products->lastItem()
            ]
        ];
    }

    public function storeProduct($request)
    {
        try {
            $productData = $request->only(['name', 'description', 'price', 'stock']);
            $product = Product::create($productData);
            $productStock = $request->only(['stock']);
            $product->stocks()->create($productStock);
            if (isset($request->category_id)) {
                $product->categories()->sync($request->category_id);
            }
            if (isset($request->images)) {
                $hasPrimary = $product->images()->where('is_primary', true)->exists();
                foreach ($request->file('images') as $key => $file) {
                    $image = $this->imageHandleService->uploadImage($file, 'products/' . Str::slug($request->name, '_') . '_' . $product->id);
                    $isPrimary = $request->has('is_primary') ?
                        $request->is_primary == $key : ($key === 0 && !$hasPrimary);
                    $product->images()->create([
                        'image' => $image,
                        'is_primary' => $isPrimary,
                    ]);
                }
            }
            return $product;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function updateProduct($request, $product)
    {
        if (!$product instanceof Product) {
            $product = Product::findByHashidOrFail($product);
        }
        // dd($product);
        $productData = $request->only(['name', 'description', 'price']);
        $product->update($productData);

        if ($request->hasFile('images')) {
            // Delete existing images if new ones are being uploaded
            $product->images()->delete();

            foreach ($request->file('images') as $key => $file) {
                $image = $this->imageHandleService->uploadImage($file, 'products/' . Str::slug($product->name, '_') . '_' . $product->id);
                $isPrimary = $request->has('is_primary') ?
                    $request->is_primary == $key : ($key === 0);

                $product->images()->create([
                    'image' => $image,
                    'is_primary' => $isPrimary,
                ]);
            }
        }

        if ($request->has('category_id')) {
            $product->categories()->sync($request->category_id);
        }
        return $product;
    }

    public function deleteProduct($product)
    {
        if (!$product instanceof Product) {
            $product = Product::findByHashidOrFail($product);
        }
        $product->delete();
        return $product;
    }

    public function updateStock($request, $product)
    {
        if (!$product instanceof Product) {
            $product = Product::findByHashidOrFail($product);
        }
        $product->stocks()->updateOrCreate(
            ['product_id' => $product->id],
            ['stock' => $request->stock]
        );
        $product->update([
            'stock' => $product->stock + $request->stock
        ]);
        return $product;
    }

    public function getProduct($product)
    {
        if (!$product instanceof Product) {
            $product = Product::findByHashidOrFail($product);
        }
        return $product;
    }
}
