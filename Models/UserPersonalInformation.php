<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;

class UserPersonalInformation extends Model
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
        'job_id',
        'weight',
        'target_weight',
        'destination_id',
        'operation',
        'medicine',
        'operation_description',
        'medicine_description',
        'eating_habit_id',
        'physical_activity_id',
        'daily_caffeine_id',
        'daily_water_id',
        'sleep_pattern_id',
        'vegan',
        'vegetarian',
        'pregnant',
        'pregnant_week_count',
        'suckle',
        'suckle_week_count',
        'blood_group',
        'special_state',
    ];

    protected $translatable = [
//        'name',
//        'description',
    ];

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->log_name = 'UserPersonalInformation';

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
            'job_id',
            'weight',
            'target_weight',
            'destination_id',
            'operation',
            'medicine',
            'operation_description',
            'medicine_description',
            'eating_habit_id',
            'physical_activity_id',
            'daily_caffeine_id',
            'daily_water_id',
            'sleep_pattern_id',
            'vegan',
            'vegetarian',
            'pregnant',
            'pregnant_week_count',
            'suckle',
            'suckle_week_count',
            'blood_group',
            'special_state',
        ]);
    }
    
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function job(){
        return $this->belongsTo(Job::class);
    }
    public function destination(){
        return $this->belongsTo(Destination::class);
    }
    public function eatingHabit(){
        return $this->belongsTo(EatingHabit::class);
    }
    public function physicalActivity(){
        return $this->belongsTo(PhysicalActivity::class);
    }
    public function dailyCaffeine(){
        return $this->belongsTo(DailyCaffeine::class);
    }
    public function dailyWater(){
        return $this->belongsTo(DailyWater::class);
    }
    public function sleepPattern(){
        return $this->belongsTo(SleepPattern::class);
    }
}


