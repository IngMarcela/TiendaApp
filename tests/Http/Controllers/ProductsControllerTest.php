<?php

namespace Tests\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Database\Factories\BrandFactory;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        for ($i = 0; $i < 5; $i++) {
            ProductFactory::new()->create();
        }

        $response = $this->get(route('product.index'));

        $response->assertOk();
        foreach (Product::all() as $product) {
            $response->assertSee($product->name);
        }
    }

    public function testCreate()
    {
        $response = $this->get(route('product.create'));

        $response->assertOk();
        $response->assertViewIs('product.create');
        $response->assertViewHas('brands');
        $brands = $response->original->getData()['brands'];
        $this->assertInstanceOf(Collection::class, $brands);
        foreach ($brands as $brand) {
            $this->assertInstanceOf(Brand::class, $brand);
        }
    }

    public function testStore()
    {
        $brand = BrandFactory::new()->create();
        $data = [
            'name' => 'Producto de prueba',
            'size' => 'M',
            'observation' => 'Observacion de prueba',
            'quantity' => 10,
            'reference' => $brand->reference,
            'shipping' => '2023-02-26',
        ];

        $response = $this->post(route('product.store'), $data);

        $response->assertRedirect(route('product.index'));
        $response->assertSessionHas('message', 'Products Agregado con exito');
        $this->assertDatabaseHas('products', $data);
    }

    public function testEdit()
    {
        $product = ProductFactory::new()->create();
        $response = $this->get(route('product.edit', $product->id));

        $response->assertSuccessful();

        $response->assertViewHas('product', $product);
        $response->assertViewHas('brands', function ($brands) use ($product) {
            return $brands->pluck('id')->contains($product->brand_id);
        });
    }

    public function testEditProduct()
    {
        $brand = BrandFactory::new()->create();
        $product = ProductFactory::new()->create(['reference'=>$brand->reference]);
        $data = [
            'name' => 'Camiseta',
            'size' => 'S',
            'observation' => 'Camiseta de algodón',
            'reference' => $brand->reference,
            'quantity' => 2,
            'shipping' => now()->toDateTimeString(),
        ];

        $response = $this->put('/product/'.$product->id, $data);

        $response->assertFound();
    }

    public function testUpdateWithValidData()
    {
        $brand = BrandFactory::new()->create();
        $product = ProductFactory::new()->create(['reference'=>$brand->reference]);
        $newData = [
            'name' => 'Producto actualizado',
            'size' => 'M',
            'observation' => 'Nueva descripcion del producto',
            'reference' => $brand->reference,
            'quantity' => 2,
            'shipping' => '2023-02-28',
        ];

        $response = $this->put(route('product.update', $product->id), $newData);

        $response->assertRedirect(route('product.index'));
        $response->assertSessionHas('message', 'Producto modificado');
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => $newData['name'],
            'size' => $newData['size'],
            'observation' => $newData['observation'],
            'reference' => $newData['reference'],
            'quantity' => $newData['quantity'],
            'shipping' => $newData['shipping'],
        ]);
    }

    public function testDeleteProduct()
    {
        $product = ProductFactory::new()->create();

        $response = $this->delete('/product/'.$product->id);

        $response->assertFound();
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
