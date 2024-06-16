<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminSettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'trash_mode' => $this->trash_mode,
            'always_update_apis' => $this->always_update_apis,
            'simple_breadcrumb' => $this->simple_breadcrumb,
        ];
    }
}
