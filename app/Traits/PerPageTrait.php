<?php

namespace App\Traits;

trait PerPageTrait
{
    /**
     * Set the number of items per page for pagination.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function scopePerPage(\Illuminate\Database\Eloquent\Builder $query, int $perPage = 25): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $perPage = request('per_page', $perPage);

        if ($perPage < 1) $perPage = 100000000;
        return $query->paginate($perPage);
    }
}
