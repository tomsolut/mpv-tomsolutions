<?php

namespace App\Policies;

use App\Enums\RolesEnum;
use App\Models\Manufacturer;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ManufacturerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole([RolesEnum::SUPER_ADMIN, RolesEnum::ADMIN]);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Manufacturer $manufacturer): bool
    {
        return $user->hasRole([RolesEnum::SUPER_ADMIN, RolesEnum::ADMIN]);
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
    public function update(User $user, Manufacturer $manufacturer): bool
    {
        return $user->hasRole([RolesEnum::SUPER_ADMIN, RolesEnum::ADMIN]);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Manufacturer $manufacturer): bool
    {
        return $user->hasRole([RolesEnum::SUPER_ADMIN, RolesEnum::ADMIN]);
    }
}
