<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Enums\ProductStatus;
use Yajra\DataTables\DataTables;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Http\UploadedFile;
use App\DataTransferObjects\{ProductDataTransferObject, ProductAttributesDataTransferObject};

class ProductApiController extends Controller
{
    public function __construct(protected ProductService $service)
    {
        // $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return DataTables::of($this->service->index())->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        try {

            $product = $this->service->store(ProductDataTransferObject::fromAppRequest($request));

            $this->service->storeAttributes($product, ProductAttributesDataTransferObject::fromAppRequest($request));

            return response()->json(['message' => 'Product created successfully.', 'data' => ProductResource::make($product)], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = $this->service->findWithAttributes($id);

        if (!$product) return response()->json(['message' => 'Product not found!'], 404);

        return response()->json(['message' => 'Product created successfully.', 'data' => ProductResource::make($product)], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {

            $product = $this->service->update($id, ProductDataTransferObject::fromAppRequest($request));

            $this->service->storeAttributes($product, ProductAttributesDataTransferObject::fromAppRequest($request));

            return response()->json(['message' => 'Product updated successfully.', 'data' => ProductResource::make($product)], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
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
