<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\CoreSettingRequest;
use App\Http\Services\CoreSettingService;
use App\Traits\ApiResponseTrait;

class CoreSettingController extends Controller
{
    use ApiResponseTrait;

    protected CoreSettingService $coreSettingService;

    public function __construct(CoreSettingService $coreSettingService)
    {
        $this->coreSettingService = $coreSettingService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        return $this->success('Success', appCoreSettings());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CoreSettingRequest $request): \Illuminate\Http\JsonResponse
    {
        $settings = $this->coreSettingService->store($request);
        return $this->success('Settings updated successfully', $settings);
    }

    public function toggleTrashMode(): \Illuminate\Http\JsonResponse
    {
        $settings = $this->coreSettingService->toggleTrashMode();
        return $this->success('Trash mode toggled successfully', $settings);
    }
}
