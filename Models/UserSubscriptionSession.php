<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;

class UserSubscriptionSession extends Model implements HasMedia
{
    use LogsActivity;
    use HasFactory;
    use InteractsWithMedia;
    use HasTranslations;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'session_type', // enum
        'order',
        'user_subscription_id',
        'meet_id',
    ];

    protected $translatable = [
        'name',
//        'description',
    ];

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->log_name = 'UserSubscriptionSession';

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
            'session_type', // enum
            'order',
            'user_subscription_id',
            'meet_id',
        ]);
    }

    public function subscription()
    {
        return $this->belongsTo(UserSubscription::class, 'user_subscription_id');
    }
    public function meet()
    {
        return $this->belongsTo(Meet::class, 'meet_id');
    }

    public function beforeAfter()
    {
        return $this->hasMany(BeforeAfter::class, 'user_subscription_session_id');
    }
    public function weeklyReports(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(WeeklyReport::class, 'session_id');
    }

    public function registerMediaConversions(Media $media = null): void
    {

        $this->addMediaConversion('crop')
            ->nonQueued()
            ->fit(Manipulations::FIT_CROP, 570, 690)
            ->performOnCollections('before_after')
            ->keepOriginalImageFormat();
        $this->addMediaConversion('crop')
            ->nonQueued()
            ->fit(Manipulations::FIT_CROP, 570, 690)
            ->performOnCollections('original')
            ->keepOriginalImageFormat();
    }
}
