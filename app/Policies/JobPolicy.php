<?php

namespace App\Policies;

use App\Models\jobs;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class JobPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->canAny('view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, jobs $job): bool
    {
        if($user->id === $job->user_id)
        {
            $user->can('view job');
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if($user->id)
        {
            return $user->can('create job'); 
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, jobs $job): bool
    {
        if($user->id === $job->user_id) 
        {
            return $user->can('update job'); 
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, jobs $job): bool
    {
        if($user->id === $job->user_id)
        {
            $user->can('delete job'); 
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, jobs $job): bool
    {
        return $user->id === $job->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, jobs $job): bool
    {
        return $user->id === $job->user_id ;
    }
}