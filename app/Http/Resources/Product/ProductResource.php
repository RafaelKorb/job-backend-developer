<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Product Resource
 *
 * @property string $name
 * @property float $price
 * @property string $description
 * @property string $category
 * @property string $image
 */
class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array of products
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'category' => $this->category,
            'image' => $this->image_url ?? null,
        ];
    }
}
