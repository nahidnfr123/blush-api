<?php

namespace App\Http\Services;

use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Support\Facades\Cache;

class RoleService
{
    public function getAll()
    {
        // request() order_by, order, per_page, query, active, featured, trash
        if ((request('trash') || isTrashModeEnabled()) || request('query')) {
            return Role::whereNotIn('slug', ['developer', 'customer'])
                ->trash()
                ->search(request('query'), ['%name', '%slug'])
                ->latest()
                ->orderBy(request('order_by', 'created_at'), request('order', 'DESC'))
                ->get();
        } else {
            $roles = Cache::rememberForever('roles', function () {
                return Role::whereNotIn('slug', ['developer', 'customer'])
                    ->latest()
                    ->get();
            });
        }

        return RoleResource::collection($roles);
    }

    public function store($request): RoleResource
    {
        $data = $request->validated();
        $role = Role::create($data);

        Cache::forget('roles');

        return new RoleResource($role);
    }

    public function update($request, $role): RoleResource
    {
        $data = $request->validated();
        $role->update($data);

        Cache::forget('roles');

        return new RoleResource($role);
    }
}
