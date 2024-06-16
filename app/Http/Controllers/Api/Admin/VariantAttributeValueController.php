<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VariantAttributes\VariantAttributeValueRequest;
use App\Http\Resources\VariantAttributeValueResource;
use App\Http\Services\HelperServices\TrashService;
use App\Http\Services\VariantAttributeService\VariantAttributeValueService;
use App\Models\VariantAttributeValue;
use App\Traits\ApiResponseTrait;

class VariantAttributeValueController extends Controller
{
    use ApiResponseTrait;

    protected VariantAttributeValueService $variantAttributeService;
    protected TrashService $trashService;

    public function __construct(VariantAttributeValueService $variantAttributeService)
    {
        $this->variantAttributeService = $variantAttributeService;
        $this->trashService = new TrashService(new VariantAttributeValue());
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $variantAttribute = $this->variantAttributeService->getAll();
        return $this->success('Success', $variantAttribute);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VariantAttributeValueRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $variantAttribute = $this->variantAttributeService->store($request);
            return $this->success('Variant Created', $variantAttribute);
        } catch (\Exception $e) {
            return $this->failure($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(VariantAttributeValue $variantAttributeValue): \Illuminate\Http\JsonResponse
    {
        $variantAttributeValue->load('variantAttribute');
        return $this->success('Success', new VariantAttributeValueResource($variantAttributeValue));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VariantAttributeValueRequest $request, VariantAttributeValue $variantAttributeValue): \Illuminate\Http\JsonResponse
    {
        try {
            $variantAttributeValue = $this->variantAttributeService->update($request, $variantAttributeValue);
            return $this->success('Variant Updated', $variantAttributeValue);
        } catch (\Exception $e) {
            return $this->failure($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VariantAttributeValue $variantAttributeValue): \Illuminate\Http\JsonResponse
    {
        try {
            $variantAttributeValue->delete();
            return $this->success('Variant Deleted');
        } catch (\Exception $e) {
            return $this->failure($e->getMessage());
        }
    }

    public function restore(VariantAttributeValue $variantAttributeValue): \Illuminate\Http\JsonResponse
    {
        return $this->trashService->restore($variantAttributeValue);
    }

    public function bulkDestroy(): \Illuminate\Http\JsonResponse
    {
        return $this->trashService->bulkDelete(request('ids'));
    }

    public function bulkRestore(): \Illuminate\Http\JsonResponse
    {
        return $this->trashService->bulkRestore(request('ids'));
    }

    public function forceDelete(VariantAttributeValue $variantAttributeValue): \Illuminate\Http\JsonResponse
    {
        return $this->trashService->forceDelete($variantAttributeValue);
    }

    public function bulkForceDelete(): \Illuminate\Http\JsonResponse
    {
        return $this->trashService->bulkForceDelete(request('ids'));
    }
}
