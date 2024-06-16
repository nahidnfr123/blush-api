<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Brand\StoreBrandRequest;
use App\Http\Requests\Brand\UpdateBrandRequest;
use App\Http\Requests\IdsRequest;
use App\Http\Resources\Brand\BrandResource;
use App\Http\Services\BrandService;
use App\Http\Services\HelperServices\TrashService;
use App\Models\Brand;
use App\Traits\ApiResponseTrait;

class BrandController extends Controller
{
    use ApiResponseTrait;

    protected BrandService $brandService;
    protected TrashService $trashService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
        $this->trashService = new TrashService(new Brand());

        $module = 'brand';
        $this->middleware(["permission:view $module|create $module|update $module|delete $module"], ['only' => ['index', 'show']]);
        $this->middleware(["permission:create $module"], ['only' => ['store']]);
        $this->middleware(["permission:update $module"], ['only' => ['update']]);
        $this->middleware(["permission:delete $module"], ['only' => ['destroy', 'bulkDestroy']]);
        $this->middleware(["permission:restore $module"], ['only' => ['restore', 'bulkRestore']]);
        $this->middleware(["permission:force delete $module"], ['only' => ['forceDelete', 'bulkForceDelete']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $brands = $this->brandService->getAll();
        return $this->success('Success', $brands);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $brand = $this->brandService->store($request);
            return $this->success('Brand created successfully', $brand);
        } catch (\Exception $e) {
            return $this->failure($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand): \Illuminate\Http\JsonResponse
    {
        $brand->load('products');
        return $this->success('Success', new BrandResource($brand));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, Brand $brand): \Illuminate\Http\JsonResponse
    {
        try {
            $brand = $this->brandService->update($request, $brand);
            return $this->success('Brand updated successfully', $brand);
        } catch (\Exception $e) {
            return $this->failure($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand): \Illuminate\Http\JsonResponse
    {
        try {
            $brand->delete();
            return $this->success('Brand deleted successfully');
        } catch (\Exception $e) {
            return $this->failure($e->getMessage());
        }
    }

    // Additional methods //
    public function bulkDestroy(IdsRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        return $this->trashService->bulkDelete($data['ids']);
    }

    public function restore(Brand $brand): \Illuminate\Http\JsonResponse
    {
        return $this->trashService->restore($brand);
    }

    public function bulkRestore(IdsRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        return $this->trashService->bulkRestore($data['ids']);
    }

    public function forceDelete(Brand $brand): \Illuminate\Http\JsonResponse
    {
        return $this->trashService->forceDelete($brand);
    }

    public function bulkForceDelete(IdsRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        return $this->trashService->bulkForceDelete($data['ids']);
    }
}
