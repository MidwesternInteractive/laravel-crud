<?php

namespace App\Policies;

use App\User;
use App\TheModel;
use Illuminate\Auth\Access\HandlesAuthorization;

class TheModelPolicy
{
    use HandlesAuthorization;

    /**
     * Check if the logged in user is an Admin.
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
     * Determine whether user can view the model.
     *
     * @param  \App\User      $user
     * @param  \App\TheModel  $theModel
     * @return mixed
     */
    public function view(User $user, TheModel $theModel = null)
    {
        return $user->can('view the model', $theModel);
    }

    /**
     * Determine whether user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->can('create the model');
    }

    /**
     * Determine whether user can update the model.
     *
     * @param  \App\User      $user
     * @param  \App\TheModel  $theModel
     * @return mixed
     */
    public function update(User $user, TheModel $theModel = null)
    {
        return $user->can('update the model', $theModel);
    }

    /**
     * Determine whether user can delete the model.
     *
     * @param  \App\User      $user
     * @param  \App\TheModel  $theModel
     * @return mixed
     */
    public function delete(User $user, TheModel $theModel)
    {
        return $user->can('delete the model', $theModel);
    }
}
