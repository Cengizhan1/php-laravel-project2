<?php

namespace App\Http\Controllers\UserApi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SubscriptionComment;
use App\Http\Resources\User\SubscriptionCommentResource;

class SubscriptionCommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->withErrorHandling(function () use($request) {
            $result = SubscriptionComment::create([
                'user_subscription_id' => $request->user_subscription_id,
                'dietician' => $request->dietician,
                'call_center' => $request->call_center,
                'diet' => $request->diet,
                'general' => $request->general,
                'body' => $request->body,
            ]);
            return response()->success(0, null, $result, 201);
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(SubscriptionComment $subscriptionComment)
    {
        return $this->withErrorHandling(function () use($subscriptionComment) {
            return SubscriptionCommentResource::make($subscriptionComment);
        });
    }
}
