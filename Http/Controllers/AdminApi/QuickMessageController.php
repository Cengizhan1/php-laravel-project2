<?php

namespace App\Http\Controllers\AdminApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuickMessage;
use App\Http\Resources\AdminApi\QuickMessageResource;

class QuickMessageController extends Controller
{

    public function index()
    {
        return QuickMessageResource::collection(QuickMessage::datatable());
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
            $locale = app()->getLocale();

            $result = QuickMessage::create([
                'admin_id' => auth()->user()->id,
                'title' => $request->title,
                'body' => $request->body,
                'date' => now(),
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
    public function show(QuickMessage $quickMessage)
    {
        return $this->withErrorHandling(function () use($quickMessage) {
            return QuickMessageResource::make($quickMessage);
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $locale = app()->getLocale();

        $result = QuickMessage::findorfail($id)->update([
            'admin_id' => auth()->user()->id,
            'title' => $request->title,
            'body' => $request->body,
            'date' => now(),
        ]);

        return response()->success(0, null, $result, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = QuickMessage::findorfail($id)->delete();
        return response()->success(0, null, $result, 201);
    }
}
