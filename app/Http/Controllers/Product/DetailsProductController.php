<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;

class DetailsProductController extends Controller
{
    /**
     * Handle de incoming request
     *
     * @param Product $product
     *
     * @return ProductResource
     */
    public function __invoke(Product $product): ProductResource
    {
        return new ProductResource($product);
    }
}
