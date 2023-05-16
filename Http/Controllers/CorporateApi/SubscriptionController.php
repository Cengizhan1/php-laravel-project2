<?php

namespace App\Http\Controllers\CorporateApi;

use App\Enum\SubscriptionPackageTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\CorporateApi\SubscriptionResource;
use App\Models\Subscription;

class SubscriptionController extends Controller
{

    public function index()
    {
        return response()->success(data:[
            'diet'=>SubscriptionResource::collection(
                Subscription::where('subscription_category', SubscriptionPackageTypeEnum::diet()->value)->get()),
            'detox'=>SubscriptionResource::collection(
                Subscription::where('subscription_category', SubscriptionPackageTypeEnum::detox()->value)->get()),
            'faceToFaceDiet'=>SubscriptionResource::collection(
                Subscription::where('subscription_category', SubscriptionPackageTypeEnum::faceToFaceDiet()->value)->get()),
        ]);
    }
}
