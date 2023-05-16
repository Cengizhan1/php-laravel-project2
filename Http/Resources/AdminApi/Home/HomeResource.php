<?php

namespace App\Http\Resources\AdminApi\Home;

use App\Models\UserSubscription;
use ObiPlus\ObiPlus\Http\Resources\Json\JsonResource;

class HomeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $dailySubscriptions = UserSubscription::query()->where('start_at', '>', now()->subDay(1))->whereIn('status',[0,6]);
        $weeklySubscriptions = UserSubscription::query()->where('start_at' , '>', now()->subWeek(1))->whereIn('status',[0,6]);
        $monthlySubscriptions = UserSubscription::query()->where('start_at' , '>', now()->subMonth(1))->whereIn('status',[0,6]);

        return [
            'daily' => [
                'total'=>$dailySubscriptions->sum('price'),
                'detox'=>$dailySubscriptions->where('subscription_category',0)->sum('price'),
                'onlineDiet'=>$dailySubscriptions->where('subscription_category',1)->sum('price'),
                'faceToFace'=>$dailySubscriptions->where('subscription_category',2)->sum('price'),
            ],
            'weekly' => [
                'total'=>$weeklySubscriptions->sum('price'),
                'detox'=>$weeklySubscriptions->where('subscription_category',0)->sum('price'),
                'onlineDiet'=>$weeklySubscriptions->where('subscription_category',1)->sum('price'),
                'faceToFace'=>$weeklySubscriptions->where('subscription_category',2)->sum('price'),
            ],
            'monthly' => [
                'total'=>$monthlySubscriptions->sum('price'),
                'detox'=>$monthlySubscriptions->where('subscription_category',0)->sum('price'),
                'onlineDiet'=>$monthlySubscriptions->where('subscription_category',1)->sum('price'),
                'faceToFace'=>$monthlySubscriptions->where('subscription_category',2)->sum('price'),
            ],
        ];
    }
}
