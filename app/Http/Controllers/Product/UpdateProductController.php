<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Services\Product\UpdateProductService;
use App\Models\Product;

class UpdateProductController extends Controller
{
    /**
     * Handle de incoming request
     *
     * @param Product $product
     *
     * @return ProductResource
     */
    public function __invoke(
        Product $product,
        UpdateProductRequest $request,
        UpdateProductService $updateProductService
    ): ProductResource {
        $product = $updateProductService($request->validated(), $product);
        return new ProductResource($product);
    }
}
