<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserWaterConsumptionResource;
use App\Http\Resources\User\UserNoteResource;
use App\Models\UserNote;
use Illuminate\Http\Request;

class UserNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->withErrorHandling(function () {
            return UserNoteResource::collection(auth()->user()->notes()->get());
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserNote  $userNote
     * @return \Illuminate\Http\Response
     */
    public function show(UserNote $userNote)
    {
        return $this->withErrorHandling(function () use($userNote){
            return UserNoteResource::make($userNote);
        });
    }

}
