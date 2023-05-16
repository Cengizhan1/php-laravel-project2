<?php

namespace App\Policies;

use App\Models\TemplateDiet;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class TemplateDietPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\Admin $admin
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(Admin $admin)
    {
        $array = Role::where('id', auth()->user()->role_id)->first()->modules;
        if(in_array(2, $array)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Admin $admin
     * @param  \App\Models\TemplateDiet  $templateDiet
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Admin $admin, TemplateDiet $templateDiet)
    {
        $array = Role::where('id', auth()->user()->role_id)->first()->modules;
        if(in_array(2, $array)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Admin $admin
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Admin $admin)
    {
        $array = Role::where('id', auth()->user()->role_id)->first()->modules;
        if(in_array(2, $array)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Admin $admin
     * @param  \App\Models\TemplateDiet  $templateDiet
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Admin $admin, TemplateDiet $templateDiet)
    {
        $array = Role::where('id', auth()->user()->role_id)->first()->modules;
        if(in_array(2, $array)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Admin $admin
     * @param  \App\Models\TemplateDiet  $templateDiet
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Admin $admin, TemplateDiet $templateDiet)
    {
        $array = Role::where('id', auth()->user()->role_id)->first()->modules;
        if(in_array(2, $array)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Admin $admin
     * @param  \App\Models\TemplateDiet  $templateDiet
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Admin $admin, TemplateDiet $templateDiet)
    {
        $array = Role::where('id', auth()->user()->role_id)->first()->modules;
        if(in_array(2, $array)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Admin $admin
     * @param  \App\Models\TemplateDiet  $templateDiet
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Admin $admin, TemplateDiet $templateDiet)
    {
        $array = Role::where('id', auth()->user()->role_id)->first()->modules;
        if(in_array(2, $array)){
            return true;
        }
        return false;
    }
}
