<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\ProductSearch\ProductSearch;
use Illuminate\Http\Request;

class SearchProductController extends Controller
{
    /**
     * Handle de incoming request
     *
     * @param Product $product
     *
     * @return ProductResource
     */
    public function __invoke(
        Request $request,
        ProductSearch $productSearch
    ) {
        $response = $productSearch->apply($request);
        $jsonResponse = [];
        foreach ($response as $product) {
            $response->toArray();
            $product['image'] = $product['image_url'];
            unset($product['image_url']);
            unset($product['id']);
            unset($product['created_at']);
            unset($product['updated_at']);
            array_push($jsonResponse, $product);
        }
        return $jsonResponse;
        /*
        $response->toArray();
        $response[0]['image'] = $response[0]['image_url'];
        unset($response[0]['image_url']);
        unset($response[0]['id']);
        unset($response[0]['created_at']);
        unset($response[0]['updated_at']);
        
        return $response[0];*/
    }
}
