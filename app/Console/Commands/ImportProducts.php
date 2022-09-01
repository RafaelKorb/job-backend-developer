<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use App\Services\Product\CreateProductService;
use App\Http\Requests\Product\CreateProductRequest;
use App\Models\Product;


class ImportProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:import {--id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'import products from external API to Database';

    /**
     * Execute the console command.
     *
     * @return JsonResponse
     */
    public function handle(CreateProductService $createProductService, Product $product)
    {
        $names = $product->pluck('name')->toArray();
        if ($this->option('id')) {
            return $this->createSingleProduct($createProductService, $names);
        }
        return $this->createMultipleProducts($createProductService, $names);
    }

    private function getSingleProduct($productId)
    {
        $response = Http::get('https://fakestoreapi.com/products/' . $productId);
        return $response;
    }

    private function createSingleProduct(CreateProductService $createProductService, array $names)
    {
        $apiProduct = $this->getSingleProduct($this->option('id'));
        if ($apiProduct->status() === 200) {
            $arrayProduct = $apiProduct->json();
            if (!in_array($arrayProduct['title'], $names)) {
                $arrayProduct['name'] = $arrayProduct['title'];
                unset($arrayProduct['id'], $arrayProduct['rating'], $arrayProduct['title']);
                $createProductService($arrayProduct);
            }
            $this->info('Produto importado com sucesso!');
            return $apiProduct->json();
        }
        $this->info('Erro ao importar os produtos, a API respondeu com status ' . $apiProduct->status());
        return $apiProduct->json();
    }

    private function createMultipleProducts(CreateProductService $createProductService, array $names)
    {
        $response = Http::get('https://fakestoreapi.com/products');
        if ($response->status() === 200) {
            foreach ($response->json() as $product) {
                if (!in_array($product['title'], $names)) {
                    $product['name'] = $product['title'];
                    unset($product['id'], $product['rating'], $product['title']);
                    $createProductService($product);
                }
            }
            $this->info('Produtos importados com sucesso!');
            return $response->json();
        };
        $this->info('Erro ao importar os produtos, a API respondeu com status ' . $response->status());
        return $response->json();
    }
}
