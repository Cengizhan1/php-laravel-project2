<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Activitylog\Contracts\Activity as SpatieActivity;
use Spatie\Translatable\HasTranslations;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;

class Subscription extends Model
{
    use LogsActivity;
    use HasFactory;
    use HasTranslations;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'subscription_category', // enum
        'price',
        
        'status',
        'vip',  // boolean
        'vip_subscription_id',
        'spec_description',
        'subscription_days',
        'stopped_limit',
        'stopped_count',
        'stopped_sessions'
    ];

    protected $casts = [
        'stopped_sessions'=>'array',
        'subscription_days' => 'array',
    ];
    protected $translatable = [
        'name',
        'spec_description',
    ];

    public function tapActivity(SpatieActivity $activity, string $eventName)
    {
        $activity->log_name = 'Subscription';

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
            'name',
            'subscription_category', // enum
            'price',
            'status',
            'vip',  // boolean
            'vip_subscription_id',
            'spec_description',
            'subscription_days'
        ]);
    }

    public function sessions(): BelongsToMany
    {
        return $this->belongsToMany(
            SubscriptionSession::class,
            'subscription_sessions_subscriptions',
            'subscription_id',
            'subscription_session_id'
        );
    }


    public function subscriptionSessions() {
        return $this->belongsToMany(SubscriptionSession::class, 'subscription_sessions_subscriptions');
    }
    public function vipSubscription(){
        return $this->belongsTo(Subscription::class,'vip_subscription_id');
    }

    public function beforeAfters() {
        return $this->hasMany(BeforeAfter::class);
    }
}


