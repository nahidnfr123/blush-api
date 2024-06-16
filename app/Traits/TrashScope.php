<?php

namespace App\Traits;

trait TrashScope
{
    public function scopeTrash($query): void
    {
        if (request('trash')) {
            match (request('trash')) {
                'only' => $query->onlyTrashed(),
                'with' => $query->withTrashed(),
                default => null,
            };
        } else if (isTrashModeEnabled()) {
            $query->onlyTrashed();
        }
    }
}
