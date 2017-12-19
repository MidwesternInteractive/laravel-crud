<?php

namespace App\Policies;

use App\User;
use App\Model;
use Illuminate\Auth\Access\HandlesAuthorization;

class ModelPolicy
{
    use HandlesAuthorization;

    /**
     * Check if the logged in model is an Admin.
     * 
     * @return mixed
     */
    public function before($user, $ability)
    {
        if ($user->hasRole('super admin')) {
            return true;
        }
    }

    /**
     * Determine whether the model can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function view(User $user, Model $model = null)
    {
        return $user->can('view model', $model);
    }

    /**
     * Determine whether the model can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->can('create model');
    }

    /**
     * Determine whether the model can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function update(User $user, Model $model = null)
    {
        return $user->can('update model', $model);
    }

    /**
     * Determine whether the model can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function delete(User $user, Model $model)
    {
        return $user->can('delete model', $model);
    }
}
