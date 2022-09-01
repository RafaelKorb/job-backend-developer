<?php

namespace App\Services\Product;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class CreateProductService
{
    /**
     * Creates a new Product
     *
     * @param array $data
     *
     * @return Model 
     */
    public function __invoke(array $data): Model
    {
        return Product::query()->create([
            'name' => $data['name'],
            'price' => $data['price'],
            'description' => $data['description'],
            'category' => $data['category'],
            'image_url' => $data['image'] ?? null,
        ]);
    }
}
