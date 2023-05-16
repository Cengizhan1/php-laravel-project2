<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;

class UserWaterConsumption extends Model
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
        'user_id',
        'date',
        'liter',
        'user_subscription_session_id',
    ];

    protected $translatable = [
//        'name',
//        'description',
    ];

    protected $casts = [
        'date' => 'date:d-m-y'
    ];

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->log_name = 'UserWaterConsumption';

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
            'user_id',
            'date',
            'liter',
            'user_subscription_session_id',
        ]);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}


