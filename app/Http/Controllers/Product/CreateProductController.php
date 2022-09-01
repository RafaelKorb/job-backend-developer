<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Services\Product\CreateProductService;

class CreateProductController extends Controller
{
    /**
     * Handle de incoming request
     *
     * @param CreateProductRequest $request
     *
     * @return ProductResource
     */
    public function __invoke(
        CreateProductRequest $request,
        CreateProductService $createProductService
    ): ProductResource {
        $product = $createProductService($request->validated());
        return new ProductResource($product);
    }
}
