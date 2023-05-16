<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;

class UserMeasurement extends Model implements HasMedia
{
    use LogsActivity;
    use HasFactory;
    use HasTranslations;
    use InteractsWithMedia;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'date',
        'waist_circumference',
        'belly_circumference',
        'upper_arm_circumference',
        'upper_leg_circumference',
        'hip_circumference',
        'chest_circumference',
        'neck_circumference',
        'diet_compatibility_id',
        'weekly_exercise_count_id',
        'message',
        'weight',
        'fat',
        'extra_cases',
        'diet_compliance_status',
        'weekly_exercise_status',
        'user_subscription_session_id',
    ];

    protected $translatable = [
        'message',
//        'description',
    ];

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->log_name = 'UserMeasurement';

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
            'waist_circumference',
            'belly_circumference',
            'upper_arm_circumference',
            'upper_leg_circumference',
            'hip_circumference',
            'chest_circumference',
            'neck_circumference',
            'diet_compatibility_id',
            'weekly_exercise_count_id',
            'message',
            'weight',
            'fat',
            'extra_cases',
            'diet_compliance_status',
            'weekly_exercise_status',
            'user_subscription_session_id',
        ]);
    }

    public function dietCompatibility(){
        return $this->belongsTo(DietCompatibility::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function weeklyExerciseCount(){
        return $this->belongsTo(WeeklyExerciseCount::class);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('crop')
            ->nonQueued()
            ->fit(Manipulations::FIT_CROP, 570, 690)
            ->performOnCollections('user_measurements')
            ->keepOriginalImageFormat();
    }
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('user_measurements')
            ->useFallbackUrl('https://via.placeholder.com/'.(1140).'x'.(690));
    }
}


