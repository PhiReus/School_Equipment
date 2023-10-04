<?php

namespace App\Policies;

use App\Models\BorrowDevice;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BorrowDevicePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('BorrowDevice_viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BorrowDevice $borrowDevice): bool
    {
        return $user->hasPermission('BorrowDevice_view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('BorrowDevice_create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BorrowDevice $borrowDevice): bool
    {
        return $user->hasPermission('BorrowDevice_update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BorrowDevice $borrowDevice): bool
    {
        return $user->hasPermission('BorrowDevice_delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BorrowDevice $borrowDevice): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BorrowDevice $borrowDevice): bool
    {
        //
    }
}
