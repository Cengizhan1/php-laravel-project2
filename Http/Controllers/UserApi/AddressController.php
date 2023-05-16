<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserApi\User\AddressRequest;
use App\Http\Resources\User\AddressResource;
use App\Http\Resources\User\UserWaterConsumptionResource;
use App\Models\Address;

class AddressController extends Controller
{

    public function index()
    {
        return $this->withErrorHandling(function () {
            return AddressResource::collection(auth()->user()->addresses);
        });
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        return $this->withErrorHandling(function () use($address){
            return AddressResource::make($address);
        });
    }
    public function store(AddressRequest $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            auth()->user()->addresses()->create(
                [
                    'name'=> $request->name,
                    'city_id' => $request->city_id,
                    'address' => $request->address,
                    'is_default' => $request->is_default ?? 0,
                ]);
            return response()->success(0, null, [], 201);
        });
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(AddressRequest $request , Address $address)
    {
        return $this->withErrorHandling(function () use ($request,$address) {
            $address->update(
                [
                    'city_id' => $request->city_id,
                    'address' => $request->address
                ]);
            return response()->success(0, null, [], 201);
        });
    }


}
