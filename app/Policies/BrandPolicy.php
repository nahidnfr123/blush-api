<?php

namespace App\Policies;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BrandPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view-any-brands');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Brand $brand): bool
    {
        return $user->hasPermissionTo('view-brands');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-brands');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Brand $brand): bool
    {
        return $user->hasPermissionTo('update-brands');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Brand $brand): bool
    {
        return $user->hasPermissionTo('delete-brands');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Brand $brand): bool
    {
        return $user->hasPermissionTo('restore-brands');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Brand $brand): bool
    {
        return $user->hasPermissionTo('force-delete-brands');
    }
}
