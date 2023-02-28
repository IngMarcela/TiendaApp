<?php

namespace Tests\Http\Controllers;

use App\Models\Brand;
use Database\Factories\BrandFactory;
use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Factory;
use Tests\TestCase;

class BrandsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $response = $this->get(route('brand.index'));

        $response->assertSuccessful();
        $response->assertViewIs('brand.index');
        $response->assertViewHas('brands');
        $brands = $response->original->getData()['brands'];
        $this->assertInstanceOf('Illuminate\Pagination\LengthAwarePaginator', $brands);
    }

    public function testCreate()
    {
        $response = $this->get(route('brand.create'));

        $response->assertSuccessful();
        $response->assertViewIs('brand.create');
    }

    public function testStoreWithValidData()
    {
        $data = [
            'name' => 'New Brand',
        ];

        $response = $this->post(route('brand.store'), $data);

        $response->assertRedirect(route('brand.index'));
        $response->assertSessionHas('message', 'Brand Agregado con exito');
        $this->assertDatabaseHas('brands', $data);
    }

    public function testStoreWithMissingName()
    {
        $data = [
        ];

        $response = $this->post(route('brand.store'), $data);

        $response->assertSessionHasErrors('name');
        $this->assertDatabaseMissing('brands', $data);
    }

    public function testEditWithValidId()
    {
        $brand = BrandFactory::new()->create([
            'name' => 'Brand prueba',
            'reference' => '1',
        ]);
        $response = $this->get(route('brand.edit', $brand->reference));

        $response->assertOk();
        $response->assertViewIs('brand.edit');
    }

    public function testEditWithInvalidId()
    {
        $response = $this->get(route('brand.edit', 'invalid-id'));

        $response->assertRedirect(route('brand.index'));
        $response->assertSessionHas('error', 'Error al cargar los datos de la marca');
    }

    public function testUpdate()
    {
        $brand = BrandFactory::new()->create([
            'name' => 'Brand prueba',
            'reference' => '1',
        ]);
        $newData = [
            'name' => 'NewBrandName',
            'reference' => '1',
        ];

        $response = $this->put(route('brand.update', ['brand' => $brand->reference]), $newData);

        $response->assertRedirect(route('brand.index'));
        $response->assertSessionHas('message', 'Brand modificada');
        $updatedBrand = Brand::where('reference', '=', $brand->reference)->firstOrFail();
        $this->assertEquals($newData['name'], $updatedBrand->name);
    }

    public function testDestroyWithValidId()
    {
        $brand = BrandFactory::new()->create([
            'name' => 'Brand prueba',
            'reference' => '1',
        ]);

        $response = $this->delete(route('brand.destroy', $brand->reference));

        $response->assertRedirect(route('brand.index'));
        $response->assertSessionHas('message', 'Brand eliminado con exito');
        $this->assertNull(Brand::where('reference', '=', $brand->reference)->first());
    }

    public function testDestroyWithInvalidId()
    {
        $response = $this->delete(route('brand.destroy', 'invalid-id'));

        $response->assertRedirect(route('brand.index'));
        $response->assertSessionHas('message', 'No se encontró la Marca');
    }

    public function testDestroyWithRelatedProducts()
    {
        $brand = BrandFactory::new()->create([
            'name' => 'Brand prueba',
            'reference' => '1',
        ]);
        ProductFactory::new()->create(['reference' => $brand->reference]);

        $response = $this->delete(route('brand.destroy', $brand->reference));

        $response->assertRedirect(route('brand.index'));
        $response->assertSessionHas('error', 'La Marca no se puede eliminar ya que contiene productos relacionados');
        $this->assertDatabaseHas('brands', ['reference' => $brand->reference]);
    }
}
