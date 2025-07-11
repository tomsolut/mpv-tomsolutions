<?php

namespace App\Policies;

use App\Enums\RolesEnum;
use App\Models\Location;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LocationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole([RolesEnum::SUPER_ADMIN, RolesEnum::ADMIN, RolesEnum::DOCTOR]);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Location $location): bool
    {
        return $user->hasRole([RolesEnum::SUPER_ADMIN, RolesEnum::ADMIN, RolesEnum::DOCTOR]);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole([RolesEnum::SUPER_ADMIN, RolesEnum::ADMIN]);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Location $location): bool
    {
        return $user->hasRole([RolesEnum::SUPER_ADMIN, RolesEnum::ADMIN]);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Location $location): bool
    {
        return $user->hasRole([RolesEnum::SUPER_ADMIN, RolesEnum::ADMIN]);
    }
}
