<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\SettingRequest;
use App\Http\Resources\SettingResource;
use App\Http\Services\SettingService;
use App\Traits\ApiResponseTrait;

class SettingsController extends Controller
{
    use ApiResponseTrait;

    protected SettingService $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        return $this->success('Success', appSettings());
    }

    public function store(SettingRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $settings = $this->settingService->store($request);
            return $this->success('Success', new SettingResource($settings));
        } catch (\Exception $e) {
            return $this->failure($e->getMessage());
        }
    }
}
