<?php

namespace App\Http\Controllers\AdminApi\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminApi\Admin\AdminIndexRequest;
use App\Http\Requests\AdminApi\Admin\AdminUpdateRequest;
use App\Http\Requests\AdminApi\Admin\AttachRoleRequest;
use App\Http\Requests\AdminApi\Admin\AdminRequest;
use App\Http\Requests\AdminApi\Customer\IndexRequest;
use App\Http\Resources\AdminApi\Admin\AdminIndexResource;
use App\Http\Resources\AdminApi\Admin\AdminShowResource;
use App\Http\Resources\AdminApi\CustomerIndexResource;
use App\Http\Resources\AdminApi\CustomerShowResource;
use App\Http\Requests\ThumbRequest;
use App\Http\Resources\AdminApi\Home\LogResource;
use App\Models\Admin;
use App\Models\User;
use App\Models\Role;
use Spatie\Activitylog\Models\Activity;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
//    public function __construct()
//    {
//        $this->authorizeResource(Admin::class);
//    }

    public function index(AdminIndexRequest $request)
    {
        return AdminIndexResource::collection(
            get_filtered_user(Admin::query(),$request)->datatable()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminRequest $request)
    {
        return $this->withErrorHandling(function () use ($request) {
             Admin::create([
                 'first_name' => $request->first_name,
                 'last_name' => $request->last_name,
                 'email' => $request->email,
                 'password' => Hash::make($request->password),
                 'phone' => $request->phone,
                 'role_id' => $request->role_id,
            ]);
            return response()->success(0, null, [], 201);
        });
    }

    public function storeAdminImage(Request $request)
    {
        return $this->withErrorHandling(function () use ($request) {

            $object = auth()->user();
            if ($request->thumb) {
                $object->clearMediaCollection('avatar');
                $object->addMedia($request->thumb)->toMediaCollection('avatar');
            }

            return response()->success(0, null, [], 201);
        });
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        return $this->withErrorHandling(function () use ($admin) {
            return AdminShowResource::make($admin);
        });
    }

    public function authAdmin()
    {
        return $this->withErrorHandling(function () {
            return AdminShowResource::make(auth()->user());
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUpdateRequest $request, Admin $admin)
    {
        return $this->withErrorHandling(function () use ($request,$admin) {

            $admin->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email ?? $admin->email,
                'password' => Hash::make($request->password ?? $admin->password),
                'role_id' => $request->role_id,
                'status' => $request->status,
            ]);
            return response()->success(0, null, [], 201);
        });
    }

    public function attachRoleToAdmin( AttachRoleRequest $request){
        return $this->withErrorHandling(function () use ($request) {
            $admin = Admin::find($request->admin_id);
            $result = $admin->update([
                'role_id' =>$request->role_id
            ]);

            return response()->success(0, null, $result, 201);
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        return $this->withErrorHandling(function () use ($admin) {
            $admin->delete();
            return response()->success(0, null, [], 201);
        });
    }

    public function log($id){
        return LogResource::collection(Activity::where('causer_type', 'App\Models\Admin')->where('causer_id', $id)->datatable());
    }
}
