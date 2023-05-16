<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\User;
use App\Models\Role;

use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(Admin $admin)
    {
        $array = Role::where('id', auth()->user()->role_id)->first()->modules;
        if(in_array(1, $array) || in_array(8, $array)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Admin $admin, User $user)
    {
        $array = Role::where('id', auth()->user()->role_id)->first()->modules;
        if(in_array(1, $array) || in_array(8, $array)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Admin $admin)
    {
        $array = Role::where('id', auth()->user()->role_id)->first()->modules;
        if(in_array(1, $array) || in_array(8, $array)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Admin $admin, User $user)
    {
        $array = Role::where('id', auth()->user()->role_id)->first()->modules;
        if(in_array(1, $array) || in_array(8, $array)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Admin $admin, User $user)
    {
        $array = Role::where('id', auth()->user()->role_id)->first()->modules;
        if(in_array(1, $array) || in_array(8, $array)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Admin $admin, User $user)
    {
        $array = Role::where('id', auth()->user()->role_id)->first()->modules;
        if(in_array(1, $array) || in_array(8, $array)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Admin $admin, User $user)
    {
        $array = Role::where('id', auth()->user()->role_id)->first()->modules;
        if(in_array(1, $array) || in_array(8, $array)){
            return true;
        }
        return false;
    }
}
