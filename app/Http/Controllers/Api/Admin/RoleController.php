<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\IdsRequest;
use App\Http\Requests\RoleRequest;
use App\Http\Services\HelperServices\TrashService;
use App\Http\Services\RoleService;
use App\Models\Role;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Cache;

class RoleController extends Controller
{
    use ApiResponseTrait;

    protected RoleService $roleService;
    protected TrashService $trashService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
        $this->trashService = new TrashService(new Role());

        $module = 'role';
        $this->middleware(["permission:view $module|create $module|update $module|delete $module"], ['only' => ['index', 'show']]);
        $this->middleware(["permission:create $module"], ['only' => ['store']]);
        $this->middleware(["permission:update $module"], ['only' => ['update']]);
        $this->middleware(["permission:delete $module"], ['only' => ['destroy', 'bulkDestroy']]);
        $this->middleware(["permission:restore $module"], ['only' => ['restore', 'bulkRestore']]);
        $this->middleware(["permission:force delete $module"], ['only' => ['forceDelete', 'bulkForceDelete']]);
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        $roles = $this->roleService->getAll();
        return $this->success('Success.', $roles);
    }

    public function show(Role $role): \Illuminate\Http\JsonResponse
    {
        return $this->success('Success.', [
            'role' => $role,
            // 'permissions' => $role->permissions->pluck('name'),
        ]);
    }

    public function store(RoleRequest $request): \Illuminate\Http\JsonResponse
    {
        $role = $this->roleService->store($request);
        return $this->success('Role created successfully.', $role);
    }

    public function update(RoleRequest $request, Role $role): \Illuminate\Http\JsonResponse
    {
        $role = $this->roleService->update($request, $role);
        return $this->success('Role updated successfully.', $role);
    }

    public function destroy(Role $role): \Illuminate\Http\JsonResponse
    {
        $role->delete();
        Cache::forget('roles');
        return $this->success('Role deleted successfully.');
    }


    // Additional methods //
    public function bulkDestroy(IdsRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        Cache::forget('roles');
        return $this->trashService->bulkDelete($data['ids']);
    }

    public function restore(Role $role): \Illuminate\Http\JsonResponse
    {
        Cache::forget('roles');
        return $this->trashService->restore($role);
    }

    public function bulkRestore(IdsRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        Cache::forget('roles');
        return $this->trashService->bulkRestore($data['ids']);
    }

    public function forceDelete(Role $role): \Illuminate\Http\JsonResponse
    {
        Cache::forget('roles');
        return $this->trashService->forceDelete($role);
    }

    public function bulkForceDelete(IdsRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        Cache::forget('roles');
        return $this->trashService->bulkForceDelete($data['ids']);
    }
}
