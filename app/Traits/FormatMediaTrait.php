<?php

namespace App\Traits;

trait FormatMediaTrait
{
    public function getMediaAttribute($media): array
    {
        return $media ? $media->map(function ($media) {
            return [
                'id' => $media->id,
                'url' => $media->getFullUrl(),
                'thumb' => $media->getFullUrl('thumb'),
                'small_thumb' => $media->getFullUrl('small_thumb'),
                'name' => $media->name,
                'file_name' => $media->file_name,
                'mime_type' => $media->mime_type,
                'size' => $media->size,
                'collection_name' => $media->collection_name,
//                    'created_at' => $media->created_at->format('Y-m-d H:i:s'),
//                    'updated_at' => $media->updated_at->format('Y-m-d H:i:s'),
            ];
        })->toArray() : [];
    }

    public function getMediaAttributeSimple($media): array
    {
        return $media ? $media->map(function ($media) {
            return [
                'id' => $media->id,
                'url' => $media->getFullUrl(),
                'thumb' => $media->getFullUrl('thumb'),
                'small_thumb' => $media->getFullUrl('small_thumb'),
                'mime_type' => $media->mime_type,
                'size' => $media->size,
            ];
        })->toArray() : [];
    }
}
