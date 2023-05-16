<?php

namespace App\Http\Controllers\AdminApi;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Resources\AdminApi\RoleResource;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return RoleResource::Collection(Role::datatable());
    }

    public function show(Role $role)
    {
        return $this->withErrorHandling(function () use ($role){
            return RoleResource::make($role);
        });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            $result = Role::create([
                'name' => $request->name,
                'modules' => $request->modules,
            ]);
            return response()->success(0, null, $result, 201);
        });
    }

    public function update(Request $request, Role $role)
    {
        return $this->withErrorHandling(function () use ($request, $role) {
            $result = $role->update([
                'name' => $request->name,
                'modules' => $request->modules,
            ]);
            return response()->success(0, null, $result, 200);
        });

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\DietCategory $dietCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        return $this->withErrorHandling(function () use ($role) {
            $result = $role->delete();
            return response()->success(0, null, $result, 200);
        });
    }
}
