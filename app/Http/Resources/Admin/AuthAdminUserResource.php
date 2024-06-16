<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\AccessControl\PermissionMinimalResource;
use App\Http\Resources\AccessControl\RoleMinimalResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthAdminUserResource extends JsonResource
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
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'trash_mode' => $this->trash_mode,
            'setting' => new AdminSettingResource($this->whenLoaded('adminSetting')),
//            'roles' => RoleMinimalResource::collection($this->whenLoaded('roles')),
            'roles' => $this->getRoleNames(),
            'permissions' => $this->getAllPermissions()->pluck('name'),
            'email_verified_at' => $this->email_verified_at,
            'mobile_verified_at' => $this->mobile_verified_at,
            'avatar' => $this->avatar,
            'status' => $this->status,
            'is_super_admin' => $this->is_super_admin,
            'created_at' => $this->created_at,
        ];
    }
}
