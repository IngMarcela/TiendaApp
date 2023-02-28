<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Product;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data['products'] = (new Product)->getAllProducts();

            return view('product.index', $data);
        } catch (Exception $e) {
            Log::error('Error al obtener los productos: '.$e->getMessage());

            return view('error')->with('Error al obtener los productos');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $brands = Cache::remember('brands', 3600, function() {
                return Brand::select('reference', 'name')->get();
            });

            return view('product.create', compact('brands'));
        } catch (Exception $e) {
            $errorMessage = 'Error al mostrar la vista de creación de producto: '.$e->getMessage();
            Log::error($errorMessage);

            return back()->withError('Error al mostrar la vista de creación de producto');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        try {
            $this->createProduct();

            return redirect('product')->with('message', 'Products Agregado con exito');
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return redirect()->route('error')->with('message', 'Ha ocurrido un error al agregar el producto');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $product = Product::findOrFail($id);
            $brands = Brand::select('reference', 'name')->get();

            return view('product.edit', compact(['product', 'brands']));
        } catch (ModelNotFoundException $e) {
            Log::error($e->getMessage());

            return redirect('product')->with('message', 'No se encontró el Producto');
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return back()->withError('Error al mostrar la vista de edición de producto');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        try {
            $this->updateProduct($id);

            return redirect('product')->with('message', 'Producto modificado');
        } catch (ModelNotFoundException $e) {
            Log::error($e->getMessage());

            return redirect('product')->with('message', 'No se encontró el Producto');
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return redirect('product')->with('error', 'Error al actualizar el producto');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Product::destroy($id);

            return redirect('product')->with('message', 'Producto eliminado con exito');
        } catch (ModelNotFoundException $e) {
            Log::error($e->getMessage());

            return redirect('product')->with('message', 'No se encontró el Producto');
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return redirect('product')->with('error', 'Error al eliminar el producto');
        }
    }

    /**
     * @return void
     */
    private function createProduct(): void
    {
        $dataProducts = request()->except('_token');
        Product::insert($dataProducts);
    }

    /**
     * @param string $id
     * @return void
     */
    private function updateProduct(string $id): void
    {
        $dataProduct = request()->except(['_token', '_method']);
        Product::where('id', '=', $id)->update($dataProduct);
    }
}
