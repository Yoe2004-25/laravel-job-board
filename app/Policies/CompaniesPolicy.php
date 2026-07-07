<?php

namespace App\Policies;

use App\Models\Companies;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CompaniesPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->canAny('viewAny'); 
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Companies $companies): bool
    {
        if ($user->id === $companies->user_id)
        {
            $user->can('view'); 
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->id)
        {
            $user->can('create');
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Companies $companies): bool
    {
        if($user->id === $companies->user_id)
        {
            $user->can('update');
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Companies $companies): bool
    {
        return $user->can('delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Companies $companies): bool
    {
        return $user->id === $companies->user_id ; 
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Companies $companies): bool
    {
        return true;
    }
}