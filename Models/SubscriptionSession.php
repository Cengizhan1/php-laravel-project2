<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;

class SubscriptionSession extends Model
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
        'session_type', // enumz
        'order',
    ];

    protected $translatable = [
        'name',
//        'description',
    ];

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->log_name = 'SubscriptionSession';

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
            'session_type', // enumz
            'order',
        ]);
    }

    public function userSubscription() {
        return $this->belongsTo(UserSubscription::class);
    }

    public function beforeAfter() {
        return $this->hasOne(BeforeAfter::class);
    }
}
