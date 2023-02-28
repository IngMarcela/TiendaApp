<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class BrandsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data['brands'] = Brand::paginate(5);

            return view('brand.index', $data);
        } catch (\Exception $e) {
            Log::error($e->getMessage(), ['trace' => $e->getTraceAsString()]);

            return view('error')->with('error', 'Ha ocurrido un error al cargar las marcas');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('brand.create');
        } catch (\Exception $e) {
            Log::error('Error al mostrar la vista de creación de marca: '.$e->getMessage());

            return back()->withError('Error al mostrar la vista de creación de marca');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandRequest $request)
    {
        try {
            $this->createBrand($request);

            return redirect()->route('brand.index')->with('message', 'Brand Agregado con exito');
        } catch (\Exception $e) {
            Log::error('Error al agregar la marca: '.$e->getMessage());

            return redirect()->route('error')->with('error', 'Ha ocurrido un error al agregar la marca');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $brand = Brand::where('reference', '=', $id)->firstOrFail();;

            return view('brand.edit', compact('brand'));
        } catch (\Throwable $th) {
            Log::error('Error al editar la Marca: '.$th->getMessage());

            return redirect('brand')->with('error', 'Error al cargar los datos de la marca');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandRequest $request, string $id)
    {
        try {
            $this->updateBrand($id);

            return redirect('brand')->with('message', 'Brand modificada');
        } catch (\Exception $e) {
            Log::error('Error al actualizar la marca: '.$e->getMessage());

            return redirect('brand')->with('error', 'Error al actualizar la marca');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $brand = Brand::where('reference', '=', $id)->firstOrFail();;
            if (!$brand->canBrandBeDeleted($id)) {
                Brand::where('reference', $id)->delete();

                return redirect('brand')->with('message', 'Brand eliminado con exito');
            }

            return redirect('brand')->with('error', 'La Marca no se puede eliminar ya que contiene productos relacionados');
        } catch (ModelNotFoundException $e) {
            Log::error('No se encontró la Marca con ID '.$id);

            return redirect('brand')->with('message', 'No se encontró la Marca');
        } catch (\Exception $e) {
            Log::error('Error al eliminar la Marca con ID '.$id.': '.$e->getMessage());

            return redirect('brand')->with('error', 'Error al eliminar la Marca');
        }
    }

    /**
     * @param Request $request
     * @return void
     */
    protected function createBrand(Request $request)
    {
        $dataBrand = $request->except('_token');
        Brand::insert($dataBrand);
        Cache::put('brands', Brand::all(), 3600);
    }

    /**
     * @param string $id
     * @return void
     */
    protected function updateBrand(string $id): void
    {
        $dataBrand = request()->except(['_token', '_method']);
        Brand::where('reference', '=', $id)->update($dataBrand);
        Cache::put('brands', Brand::all(), 3600);
    }
}
