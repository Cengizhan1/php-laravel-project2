<?php

namespace App\Http\Controllers\AdminApi\CallCenter;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminApi\Admin\AdminRequest;
use App\Http\Requests\AdminApi\CallCenter\CallCenterRequest;
use App\Http\Requests\AdminApi\CallCenter\CallCenterUpdateRequest;
use App\Http\Requests\AdminApi\Customer\IndexRequest;
use App\Http\Resources\AdminApi\Admin\AdminIndexResource;
use App\Http\Resources\AdminApi\CustomerIndexResource;
use App\Http\Resources\AdminApi\CallDemandResource;
use App\Models\Admin;
use App\Models\CallDemand;
use App\Models\User;
use App\Models\UserNote;
use Illuminate\Support\Facades\Hash;

class CallCenterController extends Controller
{

    public function __construct()
    {
//        $this->authorizeResource(UserNote::class);
//        $this->authorizeResource(User::class);
    }
    public function index(IndexRequest $request)
    {
        $customers = User::whereAvailable();

        return CustomerIndexResource::collection(
            get_filtered_user($customers,$request)->datatable()
        );
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
            return AdminIndexResource::make($admin);
        });
    }

    public function callDemand(){
        return $this->withErrorHandling(function ()  {
            return CallDemandResource::collection(CallDemand::where('seen',false)->datatable());
        });
    }
    public function seenCallDemand(CallDemand $callDemand){
        return $this->withErrorHandling(function () use ($callDemand) {
            $callDemand->update([
                'seen'=>true,
            ]);
            return response()->success(0, null, $callDemand->id, 201);
        });
    }
}
