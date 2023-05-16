<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;

class BeforeAfter extends Model implements HasMedia
{
    use LogsActivity;
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'user_subscription_session_id',
        'order',
    ];

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->log_name = 'BeforeAfter';

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
            'user_subscription_session_id',
            'order',
        ]);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('crop')
            ->nonQueued()
            ->performOnCollections('before_after')
            ->keepOriginalImageFormat();
    }
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('before_after')
            ->useFallbackUrl('https://via.placeholder.com/'.(1150).'x'.(690));
    }

    public function userSubscriptionSession() {
        return $this->belongsTo(UserSubscriptionSession::class);
    }
}
