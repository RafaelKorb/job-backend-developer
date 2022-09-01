<?php

namespace App\Services\Product;

use App\Models\Product;

class UpdateProductService
{
    /**
     * Updates a single product
     *
     * @param array $data
     * @param Product $product
     *
     * @return Product 
     */
    public function __invoke(array $data, Product $product): Product
    {
        $product->fill($data);
        $product->save();
        return $product;
    }
}
