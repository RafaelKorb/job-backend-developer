<?php

namespace Tests\Feature\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * Create Product test.
     *
     * @return void
     */
    public function testCreateProduct()
    {
        $product = Product::factory()->make()->toArray();
        $response = $this->post(route('product.create'), $product);
        $response->assertCreated();

        $this->assertDatabaseHas(Product::class, [
            'name' => $product['name'],
        ]);
    }

    /**
     * Create Product where name already exists on DB test.
     *
     * @return void
     */
    public function testCreateProductNameAlreadyExists()
    {
        $product = Product::factory()->make()->toArray();
        $response = $this->post(route('product.create'), $product);
        $response->assertCreated();
        $response = $this->post(route('product.create'), $product);
        $response->assertStatus(302);
    }

    /**
     * Get Product by name test.
     *
     * @return void
     */
    public function testSearchProductByName()
    {
        $product = Product::factory()->create();
        Product::factory()->create([
            'name' => $this->faker->name(),
        ]);
        $filters = ['name' => $product->name];
        $response = $this->searchProduct($filters);
        $this->assertTrue(count($response->json()) === 1);
        $response->assertStatus(200);
        $response->assertExactJson([
            [
                'name' => $product->name,
                'price' => $product->price,
                'category' => $product->category,
                'description' => $product->description,
                'image' => $product->image_url,
            ]
        ]);
    }

    /**
     * Get product by category test.
     *
     * @return void
     */
    public function testSearchProductByCategory()
    {
        $product = Product::factory()->create();
        Product::factory()->create([
            'category' => $this->faker->slug(10),
        ]);
        $filters = ['category' => $product->category];
        $response = $this->searchProduct($filters);
        $response->assertStatus(200);
        $this->assertTrue(count($response->json()) === 1);
        $response->assertExactJson([
            [
                'name' => $product->name,
                'price' => $product->price,
                'category' => $product->category,
                'description' => $product->description,
                'image' => $product->image_url,
            ]
        ]);
    }

    /**
     * Search products without image test.
     *
     * @return void
     */
    public function testSearchProductWithoutImage()
    {
        $product = Product::factory()->create([
            'image_url' => null
        ]);
        $product2 = Product::factory()->create([
            'image_url' => null,
            'name' => 'teste',
        ]);
        Product::factory()->create();

        $filters = ['image' => 'false'];
        $response = $this->searchProduct($filters);
        $response->assertStatus(200);
        $this->assertTrue(count($response->json()) === 2);

        $response->assertJsonFragment([
            'name' => $product->name,
            'name' => $product2->name,
        ]);
    }

    /**
     * Search products with image test.
     *
     * @return void
     */
    public function testSearchProductWithImage()
    {
        $product = Product::factory()->create();
        $product2 = Product::factory()->create();
        Product::factory()->create([
            'image_url' => null
        ]);
        $filters = ['image' => 'true'];
        $response = $this->searchProduct($filters);
        $response->assertStatus(200);
        $this->assertTrue(count($response->json()) === 2);

        $response->assertJsonFragment([
            'name' => $product->name,
            'name' => $product2->name,
        ]);
    }

    /**
     * Search products by id test.
     *
     * @return void
     */
    public function testSearchProductById()
    {
        $product = Product::factory()->create();
        Product::factory()->create();
        $filters = ['id' => $product->id];
        $response = $this->searchProduct($filters);
        $response->assertStatus(200);
        //name is unique, so we can validate by him (id not came into json response)
        $response->assertExactJson([
            [
                'name' => $product->name,
                'price' => $product->price,
                'category' => $product->category,
                'description' => $product->description,
                'image' => $product->image_url,
            ]
        ]);
    }

    /**
     * Search products by name and category test.
     *
     * @return void
     */
    public function testSearchProductByNameAndCategory()
    {
        $product = Product::factory()->create();
        Product::factory()->create([
            'category' => $product->category,
        ]);

        $filters = ['name' => $product->name, 'category' => $product->category];
        $response = $this->searchProduct($filters);
        $response->assertStatus(200);
        $this->assertTrue(count($response->json()) === 1);
        $response->assertExactJson([
            [
                'name' => $product->name,
                'price' => $product->price,
                'category' => $product->category,
                'description' => $product->description,
                'image' => $product->image_url,
            ]
        ]);
    }

    /**
     * Update Product test.
     *
     * @return void
     */
    public function testUpdateProduct()
    {
        $product = Product::factory()->create();
        $fields = [
            'name' => $this->faker->name(),
        ];
        $response = $this->patch(route('product.update', $product->id), $fields);
        $response->assertstatus(200);

        $response->assertExactJson([
            'data' => [
                'name' => $fields['name'],
                'price' => $product->price,
                'category' => $product->category,
                'description' => $product->description,
                'image' => $product->image_url,
            ]
        ]);

        $this->assertDatabaseHas(Product::class, [
            'name' => $fields['name'],
        ]);
    }

    /**
     * Delete Product test.
     *
     * @return void
     */
    public function testDeleteProduct()
    {
        $product = Product::factory()->create();
        $response = $this->delete(route('product.update', $product->id));
        $response->assertstatus(200);

        $this->assertDatabaseMissing('products', [
            'name' => $product->name,
        ]);
    }

    /**
     * @param array $filters
     *
     * @return Object
     */
    private function searchProduct(array $filters)
    {
        return $this->getJson(route('product.search', $filters));
    }
}
