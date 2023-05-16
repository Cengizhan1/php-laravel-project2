<?php

namespace App\Http\Controllers\UserApi;

use App\Enum\SubscriptionStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserApi\User\StopDietRequest;
use App\Http\Resources\User\DietResource;
use App\Http\Resources\User\RecipeResource;
use App\Models\Diet;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use MongoDB\Driver\Session;

class DietController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->withErrorHandling(function () {
            return DietResource::collection(auth()->user()->diets()->where('package_type',0)->get());
        });
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Diet  $diet
     * @return \Illuminate\Http\Response
     */
    public function show(Diet $diet)
    {
        return $this->withErrorHandling(function () use($diet){
            return DietResource::make($diet);
        });
    }
    public function currentDiet()
    {
        return $this->withErrorHandling(function (){
            $diet = auth()->user()->activeSubscription()?->diets->first();
            if (!$diet) return null;
            return DietResource::make($diet);
        });
    }

    public function allDiets()
    {
        return $this->withErrorHandling(function (){
            $diet = auth()->user()->activeSubscription()?->diets;
            if (!$diet) return null;
            return DietResource::collection($diet);
        });
    }

    public function pastDiets()
    {
        return $this->withErrorHandling(function (){
            $diet = auth()->user()->activeSubscription()?->diets->where('date', '<', now())->get();
            if (!$diet) return null;
            return DietResource::collection($diet);
        });
    }
    
    public function stopDiet(UserSubscription $subscription,StopDietRequest $request){
        return $this->withErrorHandling(function () use ($subscription,$request){
          if ($subscription->stopped_count >= $subscription->stopped_limit) return 'Durdurma hakkınız tükeniştir.';
            $availableDayCount =$subscription->stopped_count - $subscription->stopped_limit;
          if ($request->day_count > $availableDayCount ) return 'Durdurmak istediğiniz gün sayısı limitinizden ' .
              'fazla! Durdurabileceğiniz gün sayısı : '.$availableDayCount;

          $subscription->update([
              'status'=>SubscriptionStatusEnum::stopped()->value,
              'stopped_at'=>now(),
              'restarted_at'=>now()->addDay($request->day_count),
              'stopped_count'=>$subscription->stopped_count+$request->day_count,
          ]);
          foreach ($subscription->sessions()->where('start_at' ,'>',now())->get() as $session){
              $startAt = Carbon::parse($session->meet->start_at)->addDay($request->day_count);
              $endAt = Carbon::parse($session->meet->end_at)->addDay($request->day_count);
              $session->update([
                  'start_at'=>re_date_meet($startAt,$subscription->subscription_days),
                  'end_at'=>re_date_meet($endAt,$subscription->subscription_days),
              ]);
          }
            return response()->success(0, null, [], 201);
        });
    }

    public function reStartDiet(UserSubscription $subscription){
        return $this->withErrorHandling(function () use ($subscription){
            $start = now();
            $end = $subscription->restarted_at;
            $diff = $start->diffInDays($end);

            foreach ($subscription->sessions()->where('start_at' ,'>',now())->get() as $session){
                $startAt = Carbon::parse($session->meet->start_at)->subDay($diff);
                $endAt = Carbon::parse($session->meet->end_at)->subDay($diff);
                $session->update([
                    'start_at'=>re_date_meet($startAt,$subscription->subscription_days),
                    'end_at'=>re_date_meet($endAt,$subscription->subscription_days),
                ]);
            }

            $subscription->update([
                'status'=>SubscriptionStatusEnum::active()->value,
                'stopped_at'=>null,
                'restarted_at'=>null,
                'stopped_count'=>$subscription->stopped_count-$diff,
            ]);
            return response()->success(0, null, [], 201);
        });
    }

}
