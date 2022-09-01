<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Services\Product\DeleteProductService;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class DeleteProductController extends Controller
{
    /**
     * Handle de incoming request
     *
     * @param Product $product
     *
     * @return ProductResource
     */
    public function __invoke(
        int $product,
        DeleteProductService $deleteProductService
    ): JsonResponse {
        $deleteProductService($product);
        return response()->json([], 200);
    }
}
