<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Permission;
use App\Models\Role;

class PermissionController extends Controller
{
    use ApiResponseTrait;

    public function index(): \Illuminate\Http\JsonResponse
    {
        // Cache::forget('permissions');
        $permissions = Cache::rememberForever('permissions', function () {
            return Permission::where('special', 0)->get(['id', 'name', 'type'])->groupBy('type');
        });

        if (request()->has('role')) {
            $role = Role::findBySlug(request('role'));
            $permissions = Cache::rememberForever($role->name . '-all-permissions-check-list', function () use ($role, $permissions) {
                return $permissions->map(function ($permission) use ($role) {
                    $permission->map(function ($p) use ($role) {
                        $p->setAttribute('assigned', $role->hasPermissionTo($p->name));
                    });
                    return $permission;
                });
            });
        }

        return $this->success('Success.', $permissions);
    }

    public function assignPermissionToRole(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validate([
            'role' => 'required|string|exists:roles,slug',
            'permissions' => 'required|array',
        ]);

        $role = Role::findBySlug(request('role'));
        $permissionNames = Permission::whereIn('id', $data['permissions'])->pluck('name')->toArray();
        $role->syncPermissions($permissionNames);

        Cache::forget($role->name . '-all-permissions-check-list');

        return response()->json([
            'message' => 'Permissions assigned to role successfully.',
        ]);
    }
}
