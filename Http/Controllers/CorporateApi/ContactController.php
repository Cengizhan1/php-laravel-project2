<?php

namespace App\Http\Controllers\CorporateApi;

use App\Http\Controllers\Controller;
use App\Http\Requests\CorporateApi\CallDemandRequest;
use App\Http\Requests\CorporateApi\ContactStoreRequest;
use App\Models\CallDemand;
use App\Models\Contact;

class ContactController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactStoreRequest $request)
    {
        return $this->withErrorHandling(function () use($request) {
            $result = Contact::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
            ]);

            return response()->success(
                data: $result
            );
        });
    }

    public function callDemand(CallDemandRequest $request)
    {
        return $this->withErrorHandling(function () use($request) {
            $result = CallDemand::create([
                'name' => $request->name,
                'phone' => $request->phone,
            ]);

            return response()->success(
                data: $result
            );
        });
    }
}
