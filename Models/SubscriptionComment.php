<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;

class SubscriptionComment extends Model
{
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_subscription_id',
        'dietician',
        'call_center',
        'diet',
        'general',
        'body',
    ];

    public function userSubscription(){
        return $this->belongsTo(UserSubscription::class);
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->log_name = 'SubscriptionComment';

        if($activity->causer_type == 'App\\Models\\Admin'){
            $person = Admin::find($activity->causer_id)->first_name;
            $activity->description = $person;
        }

        if($activity->causer_type == 'App\\Models\\User'){
            $person = User::find($activity->causer_id)->first_name;
            $activity->description = $person;
        }
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly([
            'body',
            'dietician',
            'call_center',
            'diet_program',
            'user_subscription_id',
        ]);
    }
}
