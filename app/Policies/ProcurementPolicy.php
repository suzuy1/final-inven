<?php

namespace App\Policies;

use App\Enums\ProcurementStatus;
use App\Models\Procurement;
use App\Models\User;

class ProcurementPolicy
{
    /**
     * Determine whether the user can view any models.
     * All authenticated users can see procurements (filtered by role in controller)
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     * Users can only view their own procurements, admins can view all
     */
    public function view(User $user, Procurement $procurement): bool
    {
        return $user->role === 'admin' || $user->id === $procurement->user_id;
    }

    /**
     * Determine whether the user can create models.
     * All authenticated users can create procurement requests
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     * Only admin can update procurement (change status)
     */
    public function update(User $user, Procurement $procurement): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the status.
     * Only admin can approve/reject/complete
     */
    public function updateStatus(User $user, Procurement $procurement): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     * Admin can delete any, user can only delete their own pending procurements
     */
    public function delete(User $user, Procurement $procurement): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        return $user->id === $procurement->user_id
            && $procurement->status === ProcurementStatus::PENDING;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Procurement $procurement): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Procurement $procurement): bool
    {
        return $user->role === 'admin';
    }
}

