<?php

namespace App\Policies;

use App\Enums\DisposalStatus;
use App\Models\Disposal;
use App\Models\User;

class DisposalPolicy
{
    /**
     * Determine whether the user can view any models.
     * All authenticated users can see disposals
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     * Users can view their own requests, admins can view all
     */
    public function view(User $user, Disposal $disposal): bool
    {
        return $user->role === 'admin' || $user->id === $disposal->requested_by;
    }

    /**
     * Determine whether the user can create models.
     * All authenticated users can create disposal requests
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     * Only admin can update disposals
     */
    public function update(User $user, Disposal $disposal): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can approve the disposal.
     * Only admin can approve pending disposals
     */
    public function approve(User $user, Disposal $disposal): bool
    {
        return $user->role === 'admin'
            && $disposal->status === DisposalStatus::PENDING
            && $disposal->canBeApproved();
    }

    /**
     * Determine whether the user can reject the disposal.
     * Only admin can reject pending disposals
     */
    public function reject(User $user, Disposal $disposal): bool
    {
        return $user->role === 'admin'
            && $disposal->status === DisposalStatus::PENDING;
    }

    /**
     * Determine whether the user can review the disposal.
     * Only admin can access review page
     */
    public function review(User $user, Disposal $disposal): bool
    {
        return $user->role === 'admin'
            && $disposal->status === DisposalStatus::PENDING;
    }

    /**
     * Determine whether the user can delete the model.
     * Only admin can delete, or requester if still pending
     */
    public function delete(User $user, Disposal $disposal): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        return $user->id === $disposal->requested_by
            && $disposal->status === DisposalStatus::PENDING;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Disposal $disposal): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Disposal $disposal): bool
    {
        return $user->role === 'admin';
    }
}

