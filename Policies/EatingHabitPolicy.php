<?php

namespace App\Policies;

use App\Models\EatingHabit;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class EatingHabitPolicy
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
        if(in_array(9, $array)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\EatingHabit  $eatingHabit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Admin $admin, EatingHabit $eatingHabit)
    {
        $array = Role::where('id', auth()->user()->role_id)->first()->modules;
        if(in_array(9, $array)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Admin $admin)
    {
        $array = Role::where('id', auth()->user()->role_id)->first()->modules;
        if(in_array(9, $array)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\EatingHabit  $eatingHabit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Admin $admin, EatingHabit $eatingHabit)
    {
        $array = Role::where('id', auth()->user()->role_id)->first()->modules;
        if(in_array(9, $array)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\EatingHabit  $eatingHabit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Admin $admin, EatingHabit $eatingHabit)
    {
        $array = Role::where('id', auth()->user()->role_id)->first()->modules;
        if(in_array(9, $array)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $admin
     * @param  \App\Models\EatingHabit  $eatingHabit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Admin $admin, EatingHabit $eatingHabit)
    {
        $array = Role::where('id', auth()->user()->role_id)->first()->modules;
        if(in_array(9, $array)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\EatingHabit  $eatingHabit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Admin $admin, EatingHabit $clinic)
    {
        $array = Role::where('id', auth()->user()->role_id)->first()->modules;
        if(in_array(9, $array)){
            return true;
        }
        return false;
    }
}
