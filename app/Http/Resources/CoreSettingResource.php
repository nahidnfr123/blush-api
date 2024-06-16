<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CoreSettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'maintenance_mode' => $this->maintenance_mode,
            'always_upto_date' => $this->always_upto_date,
            'developer_percentage' => $this->developer_percentage,
            'locale' => $this->locale,
            'timezone' => $this->timezone,
            'currency_name' => $this->currency_name,
            'currency_code' => $this->currency_code,
            'currency_symbol' => $this->currency_symbol,
        ];
    }
}
