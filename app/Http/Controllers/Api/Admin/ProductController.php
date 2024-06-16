<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Http\Services\HelperServices\TrashService;
use App\Http\Services\ProductService;
use App\Models\Product;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    use ApiResponseTrait;

    protected ProductService $productService;
    protected TrashService $trashService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
        $this->trashService = new TrashService(new Product());
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $products = $this->productService->getAll();
        return $this->success('Success', ProductCollection::make($products));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $product = $this->productService->store($request);
            DB::commit();
            return $this->success('Product Created', new ProductResource($product));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->failure($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): \Illuminate\Http\JsonResponse
    {
        $product->load('brand', 'categories', 'tags', 'productDetail', 'media', 'createdBy', 'updatedBy', 'productVariants', 'productVariants.media');
        return $this->success('Success', new ProductResource($product));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $product = $this->productService->update($request, $product);
            DB::commit();
            return $this->success('Product Updated', new ProductResource($product));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->failure($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): \Illuminate\Http\JsonResponse
    {
        try {
            $product->delete();
            return $this->success('Product Deleted');
        } catch (\Exception $e) {
            return $this->failure($e->getMessage());
        }
    }


    public function bulkDestroy(): \Illuminate\Http\JsonResponse
    {
        return $this->trashService->bulkDelete(request('ids'));
    }

    public function restore(Product $product): \Illuminate\Http\JsonResponse
    {
        return $this->trashService->restore($product);
    }

    public function bulkRestore(): \Illuminate\Http\JsonResponse
    {
        return $this->trashService->bulkRestore(request('ids'));
    }

    public function forceDelete(Product $product): \Illuminate\Http\JsonResponse
    {
        return $this->trashService->forceDelete($product);
    }

    public function bulkForceDelete(): \Illuminate\Http\JsonResponse
    {
        return $this->trashService->bulkForceDelete(request('ids'));
    }
}
