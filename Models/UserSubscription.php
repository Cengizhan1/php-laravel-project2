<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;

class UserSubscription extends Model
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
        'subscription_id',
        'user_id',
        'name',
        'subscription_category', // enum
        'payment_method', // enum
        'price',
        'status',
        'stopped_at',
        'restarted_at',
        'stopped_count',
        'stopped_limit',
        'stopped_sessions',
        'vip',  // boolean
        'vip_subscription_id',
        'spec_description',
        'subscription_days',
        'start_at',
        'end_at',
    ];
    protected $casts = [
        'stopped_at'=>'datetime',
        'restarted_at'=>'datetime',
        'stopped_sessions'=>'array',
        'subscription_days'=>'array',
        'spec_description'=>'json',
    ];
    protected $translatable = [
        'name',
//        'description',
    ];

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->log_name = 'UserSubscription';

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
            'subscription_id',
            'user_id',
            'name',
            'subscription_category', // enum
            'payment_method', // enum
            'price',
            'status',
            'stopped_at',
            'restarted_at',
            'stopped_count',
            'stopped_limit',
            'stopped_sessions',
            'vip',  // boolean
            'vip_subscription_id',
            'spec_description',
            'subscription_days',
            'start_at',
            'end_at',
        ]);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function diets(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Diet::class, 'user_subscription_id');
    }
    public function reports(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Report::class, 'user_subscription_id');
    }

    public function sessions(){
        return $this->hasMany(UserSubscriptionSession::class);
    }

    public function subscriptionComments(){
        return $this->hasMany(SubscriptionComment::class);
    }
    public function payments(){
        return $this->hasMany(PaymentHistory::class);
    }
    public function getRemainingAmountAttribute(){
        return $this->price - $this->payments()->sum('amount');
    }
}
