<?php

namespace App\Http\Services;

use App\Http\Resources\CoreSettingResource;
use App\Models\CoreSetting;

class CoreSettingService
{
    public function store($request): CoreSettingResource
    {
        $data = $request->validated();
        $settings = CoreSetting::updateOrCreate(['id' => 1], $data);
        return new CoreSettingResource($settings);
    }
}
