<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'page_id' => $this->page_id,
            'title' => $this->title,
            'title_bn' => $this->title_bn,
            'slug' => $this->slug,
            'content' => $this->content,
            'view_more_url' => $this->view_more_url,
            'api_url' => $this->api_url,
            'class_name' => $this->class_name,
            'type' => $this->type,
            'autoplay' => $this->autoplay,
            'active' => $this->active,
            'order' => $this->order,

            'sectionable_id' => $this->sectionable_id,
            'sectionable_type' => $this->sectionable_type,

            'created_at' => $this->created_at,
        ];
    }
}
