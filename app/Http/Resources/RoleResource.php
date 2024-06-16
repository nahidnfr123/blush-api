<?php

namespace App\Http\Resources;

use App\Enums\GuardEnums as Guard;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $canAssignPermission = false;
        if ($this->slug === 'developer') {
            $canAssignPermission = false;
        } else {
            if (auth(Guard::Admin->value)->user()->hasRole('developer')) {
                $canAssignPermission = true;
            } else {
                if (auth(Guard::Admin->value)->user()->hasRole($this->name)) {
                    $canAssignPermission = false;
                } else if (auth(Guard::Admin->value)->user()->can('assign permission to role')) {
                    $canAssignPermission = true;
                }
            }
        }


        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'guard_name' => $this->guard_name,
            'permission_count' => $this->permissions->count(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deletable' => !in_array($this->name, ['developer', 'super admin', 'admin', 'customer']),
            'can_assign_permission' => $canAssignPermission,
        ];
    }
}
