<?php

namespace App\Services\Product;

use App\Models\Product;

class DeleteProductService
{
    /**
     * Delete a single product
     *
     * @param int $product
     *
     * @return void
     */
    public function __invoke(int $productId): void
    {
        Product::where('id', $productId)->delete();
    }
}
