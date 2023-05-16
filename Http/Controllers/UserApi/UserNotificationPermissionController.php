<?php

namespace App\Http\Controllers\UserApi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserNotificationPermissionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->withErrorHandling(function () use($request){
            $result = auth()->user()->permission()->update([
                'sms_notification' => $request->sms,
                'email_notification' => $request->email,
                'app_notification' => $request->app,
            ]);

            return response()->success(0,null, $result, 201);
        });
    }
}
