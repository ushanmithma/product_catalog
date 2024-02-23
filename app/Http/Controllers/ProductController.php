<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Enums\ProductStatus;
use Yajra\DataTables\DataTables;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Http\UploadedFile;
use App\DataTransferObjects\{ProductDataTransferObject, ProductAttributesDataTransferObject};

class ProductController extends Controller
{
    public function __construct(protected ProductService $service)
    {
        // $this->middleware('auth');
    }

    /**
     * Get products for datatable
     */
    public function table()
    {
        return DataTables::of($this->service->index())->make(true);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('products.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        try {

            $product = $this->service->store(ProductDataTransferObject::fromAppRequest($request));

            $this->service->storeAttributes($product, ProductAttributesDataTransferObject::fromAppRequest($request));

            return redirect()->route('products.index')->with(['message' => 'Product created successfully.']);

        } catch (\Exception $e) {
            return redirect()->route('products.create')->with(["message" => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = $this->service->findWithAttributes($id);

        if (!$product) return redirect()->back();

        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = $this->service->findWithAttributes($id);

        if (!$product) return redirect()->back();

        return view('products.create', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        try {

            $product = $this->service->update($id, ProductDataTransferObject::fromAppRequest($request));

            $this->service->storeAttributes($product, ProductAttributesDataTransferObject::fromAppRequest($request));

            return redirect()->route('products.index')->with(['message' => 'Product updated successfully.']);

        } catch (\Exception $e) {
            return redirect()->route('products.create')->with(["message" => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            $this->service()->delete($id);

            return response()->json(['message' => 'Product deleted successfully.'], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
