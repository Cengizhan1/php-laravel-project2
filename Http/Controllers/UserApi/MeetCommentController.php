<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserApi\User\MeetCommentStoreRequest;
use App\Http\Resources\User\MeetCommentResource;
use App\Models\Meet;
use App\Models\MeetComment;

use Illuminate\Http\Request;

class MeetCommentController extends Controller
{
    public function getMeetComments(Meet $meet)
    {
        return $this->withErrorHandling(function () use ($meet) {
            return MeetCommentResource::collection($meet->comments);
        });
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MeetCommentStoreRequest $request)
    {

        return $this->withErrorHandling(function () use($request) {
            $result = MeetComment::create([
                'meet_id' => $request->meet_id,
                'stars' => $request->stars,
                'body' => $request->body,
            ]);
            return response()->success(0, null, $result->id, 201);
        });
    }
}
