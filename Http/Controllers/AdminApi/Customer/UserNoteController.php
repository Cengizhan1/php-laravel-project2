<?php

namespace App\Http\Controllers\AdminApi\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminApi\Customer\UserNoteRequest;
use App\Http\Resources\User\UserNoteResource;
use App\Models\User;
use App\Models\UserNote;
use Illuminate\Http\Request;

class  UserNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user, UserNoteRequest $request)
    {
        return $this->withErrorHandling(function () use ($user, $request) {

            if ($request->note_type == 0) {
                return UserNoteResource::collection($user->notes()->datatable());
            } else {
                return UserNoteResource::collection($user->callCenterNote()->datatable());
            }
        });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            $result = Usernote::create([
                'admin_id' => auth()->user()->id,
                'user_id' => $request->user_id,
                'note' => $request->note,
                'call_result_state' => $request->call_result_state, // Enum
                'date' => now()
            ]);

            return $result;
        });
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\UserNote $userNote
     * @return \Illuminate\Http\Response
     */
    public function show(UserNote $userNote)
    {
        return $this->withErrorHandling(function () use ($userNote) {
            return UserNoteResource::make($userNote);
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\UserNote $userNote
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserNote $userNote)
    {
        return $this->withErrorHandling(function () use ($userNote) {
            return $userNote->delete();
        });
    }
}
