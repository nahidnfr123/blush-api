<?php

namespace App\Http\Services;

use App\Enums\GuardEnums as Guard;
use App\Models\Admin;
use App\Models\AdminSetting;
use Illuminate\Support\Facades\Auth;

class AdminUserService
{

    public function getAll()
    {

    }

    public function store($request): Admin
    {
        $data = $request->validated();
        unset($data['avatar_link']);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = uploadFile($request->avatar, 'images/avatar', $data['name']);
        }
        if ($request->avatar_link && file_exists(storage_path('app/public/' . $request->avatar_link))) {
            $data['avatar'] = $request->avatar_link;
        }

        $admin = new Admin();
        $admin->fill($data)->save();

        $admin->adminSetting()->create([]);
        $admin->load('adminSetting');

        return $admin;
    }

    public function update($request, $admin)
    {
        $data = $request->validated();
        unset($data['avatar_link']);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = uploadFile($request->avatar, 'images/avatar', $admin->name);
        }
        if ($request->avatar_link && file_exists(storage_path('app/public/' . $request->avatar_link))) {
            $data['avatar'] = $request->avatar_link;
        }

        $admin->fill($data)->save();

        AdminSetting::where('admin_id', $admin->id)->firstOrFail()->fill($data)->save();
        $admin->load('adminSetting');

        return $admin;
    }

    public function updateProfile($request, $admin)
    {
        $authUser = Auth::guard(Guard::Admin->value)->user();
        if ($admin->id !== $authUser->id) {
            abort(403, 'Invalid update request!');
        }

        $data = $request->validated();
        unset($data['avatar_link']);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = uploadFile($request->avatar, 'images/avatar', $admin->name);
        }
        if ($request->avatar_link && file_exists(storage_path('app/public/' . $request->avatar_link))) {
            $data['avatar'] = $request->avatar_link;
        }

        $admin->fill($data)->save();

        AdminSetting::where('admin_id', $admin->id)->firstOrFail()->fill($data)->save();
        $admin->load('adminSetting');

        return $admin;
    }

    public function delete($admin)
    {

    }
}
