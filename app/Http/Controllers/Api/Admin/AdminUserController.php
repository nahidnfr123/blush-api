<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminUserStoreRequest;
use App\Http\Requests\AdminUserUpdateRequest;
use App\Http\Requests\IdsRequest;
use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Resources\Admin\AuthAdminUserResource;
use App\Http\Services\AdminUserService;
use App\Http\Services\HelperServices\TrashService;
use App\Models\Admin;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminUserController extends Controller
{
    use ApiResponseTrait;

    protected AdminUserService $adminUserService;
    protected TrashService $trashService;

    public function __construct(AdminUserService $adminUserService)
    {
        $this->adminUserService = $adminUserService;
        $this->trashService = new TrashService(new Admin());
    }

    public function index()
    {

    }

    public function store(AdminUserStoreRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            abort_if(!request()->user()->tokenCan('check-admin'), 401, 'Unauthorized');
            $admin = $this->adminUserService->store($request);
            DB::commit();
            return $this->success('User created successfully.', new AuthAdminUserResource($admin));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->failure($e->getMessage());
        }
    }

    public function show(Admin $admin): \Illuminate\Http\JsonResponse
    {
        $admin->load('adminSetting');
        return $this->success('Successfully.', new AuthAdminUserResource($admin));
    }

    public function update(AdminUserUpdateRequest $request, Admin $admin): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            abort_if(!$request->user()->tokenCan('check-admin'), 401, 'Unauthorized');
            $admin = $this->adminUserService->update($request, $admin);
            DB::commit();
            return $this->success('User updated successfully.', new AuthAdminUserResource($admin));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->failure($e->getMessage());
        }
    }


    public function updateProfile(AdminUserUpdateRequest $request, Admin $admin): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            abort_if(!$request->user()->tokenCan('check-admin'), 401, 'Unauthorized');
            $admin = $this->adminUserService->updateProfile($request, $admin);
            DB::commit();
            return $this->success('Profile updated successfully.', new AuthAdminUserResource($admin));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->failure($e->getMessage());
        }
    }

    public function destroy(Admin $admin): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            abort_if(!request()->user()->tokenCan('check-admin'), 401, 'Unauthorized');
            $admin->adminSetting()->delete();
            $admin->delete();
            DB::commit();
            return $this->success('User deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->failure($e->getMessage());
        }
    }

    /**
     * @throws ValidationException
     */
    public function updatePassword(PasswordUpdateRequest $request): \Illuminate\Http\JsonResponse
    {
        abort_if(!$request->user()->tokenCan('check-admin'), 401, 'Unauthorized');

        $authUser = Auth::user();
        $user = Admin::findOrFail($authUser->id);
        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['Current password is incorrect.'],
            ]);
        }
        try {
            $user->fill([
                'password' => Hash::make($request->password)
            ])->save();

            return $this->success('User password updated.');
        } catch (\Exception $e) {
            return $this->failure($e->getMessage(), 500);
        }
    }

    public function toggleTrashMode(): \Illuminate\Http\JsonResponse
    {
        try {
            $user = auth()->user();
            $user->adminSetting()->updateOrCreate([
                'admin_id' => $user->id
            ], [
                'trash_mode' => !$user->trash_mode
            ]);
            $user->refresh();

            return $this->success('Trash mode ' . ($user->trash_mode ? 'enabled' : 'disabled') . ' successfully');
        } catch (\Exception $e) {
            return $this->failure($e->getMessage(), 500);
        }
    }


    // Additional methods //
    public function bulkDestroy(IdsRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        return $this->trashService->bulkDelete($data['ids']);
    }

    public function restore(Admin $admin): \Illuminate\Http\JsonResponse
    {
        return $this->trashService->restore($admin);
    }

    public function bulkRestore(IdsRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        return $this->trashService->bulkRestore($data['ids']);
    }

    public function forceDelete(Admin $admin): \Illuminate\Http\JsonResponse
    {
        return $this->trashService->forceDelete($admin);
    }

    public function bulkForceDelete(IdsRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        return $this->trashService->bulkForceDelete($data['ids']);
    }
}
