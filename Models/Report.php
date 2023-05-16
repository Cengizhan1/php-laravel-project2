<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;

class Report extends Model
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
        'total_fat_rate_change',
        'weight_change',
        'water_consumption',
        'user_id',
        'user_subscription_id',
        'date',
    ];

    protected $translatable = [
//        'name',
//        'description',
    ];

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->log_name = 'Report';

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
            'total_fat_rate_change',
            'weight_change',
            'water_consumption',
            'user_id',
            'subscription_id',
            'date',
        ]);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function subscription(){
        return $this->belongsTo(UserSubscription::class);
    }
    public function weeklyReports(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(WeeklyReport::class, 'report_id');
    }
}


