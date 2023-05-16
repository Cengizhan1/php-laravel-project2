<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;

class UserCalorie extends Model
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
        'time',
        'activity_id',
        'user_subscription_session_id',
        'date',
    ];

    protected $appends = [
        'total_calorie'
    ];

    public function getTotalCalorieAttribute(){
        return $this->activity->specialCalorie * $this->time;
    }

    protected $casts = [
        'date' => 'date:y-m-d'
    ];

    protected $translatable = [
//        'name',
//        'description',
    ];

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->log_name = 'UserCalorie';

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
            'time',
            'activity_id',
            'user_subscription_session_id',
            'date',
        ]);
    }

    public function activity(){
        return $this->belongsTo(Activity::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}


