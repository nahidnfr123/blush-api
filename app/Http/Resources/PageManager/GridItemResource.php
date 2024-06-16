<?php

namespace App\Http\Resources\PageManager;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GridItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'title_bn' => $this->title_bn,
            'subtitle' => $this->subtitle,
            'subtitle_bn' => $this->subtitle_bn,
            'button_text' => $this->button_text,
            'button_text_bn' => $this->button_text_bn,
            'url' => $this->url,
            'image' => $this->image,
            'class_name' => $this->class_name,
            'height' => $this->height,
            'order' => $this->order,
        ];
    }
}
