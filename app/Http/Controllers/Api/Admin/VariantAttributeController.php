<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VariantAttributes\StoreVariantRequest;
use App\Http\Requests\VariantAttributes\UpdateVariantRequest;
use App\Http\Resources\VariantAttributes\VariantAttributeCollection;
use App\Http\Resources\VariantAttributes\VariantAttributeResource;
use App\Http\Services\HelperServices\TrashService;
use App\Http\Services\VariantAttributeService\VariantAttributeService;
use App\Models\VariantAttribute;
use App\Traits\ApiResponseTrait;

class VariantAttributeController extends Controller
{
    use ApiResponseTrait;

    protected VariantAttributeService $variantAttributeService;
    protected TrashService $trashService;

    public function __construct(VariantAttributeService $variantAttributeService)
    {
        $this->variantAttributeService = $variantAttributeService;
        $this->trashService = new TrashService(new VariantAttribute());
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $variantAttribute = $this->variantAttributeService->getAll();
        return $this->success('Success', VariantAttributeCollection::make($variantAttribute));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVariantRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $variantAttribute = $this->variantAttributeService->store($request);
            return $this->success('Variant Created', new VariantAttributeResource($variantAttribute));
        } catch (\Exception $e) {
            return $this->failure($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(VariantAttribute $variant_attribute): \Illuminate\Http\JsonResponse
    {
        $variant_attribute->load('variantAttributeValues');
        return $this->success('Success', new VariantAttributeResource($variant_attribute));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVariantRequest $request, VariantAttribute $variant_attribute): \Illuminate\Http\JsonResponse
    {
        try {
            $variantAttribute = $this->variantAttributeService->update($request, $variant_attribute);
            return $this->success('Variant Updated', new VariantAttributeResource($variantAttribute));
        } catch (\Exception $e) {
            return $this->failure($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VariantAttribute $variant_attribute): \Illuminate\Http\JsonResponse
    {
        try {
            $variant_attribute->delete();
            return $this->success('Variant Deleted', $variant_attribute);
        } catch (\Exception $e) {
            return $this->failure($e->getMessage());
        }
    }


    public function bulkDestroy(): \Illuminate\Http\JsonResponse
    {
        return $this->trashService->bulkDelete(request('ids'));
    }

    public function restore(VariantAttribute $variant_attribute): \Illuminate\Http\JsonResponse
    {
        return $this->trashService->restore($variant_attribute);
    }

    public function bulkRestore(): \Illuminate\Http\JsonResponse
    {
        return $this->trashService->bulkRestore(request('ids'));
    }

    public function forceDelete(VariantAttribute $variant_attribute): \Illuminate\Http\JsonResponse
    {
        return $this->trashService->forceDelete($variant_attribute);
    }

    public function bulkForceDelete(): \Illuminate\Http\JsonResponse
    {
        return $this->trashService->bulkForceDelete(request('ids'));
    }
}
