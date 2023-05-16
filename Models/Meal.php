<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;

class Meal extends Model implements HasMedia
{
    use LogsActivity;
    use HasFactory;
    use HasTranslations;
    use InteractsWithMedia;
//    use SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'relation_type',
        'relation_id',
        'start_at',
        'end_at',
        'meal_time_id',
        'message',
    ];
    protected $casts = [
        'start_at'=>'datetime',
        'end_at'=>'datetime',
    ];

    protected $translatable = [
//        'name',
//        'description',
    ];

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->log_name = 'Meal';

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
            'relation_type',
            'relation_id',
            'start_at',
            'end_at',
            'meal_time_id',
            'message',
        ]);
    }

    public function nutrients(): BelongsToMany{
        return $this->belongsToMany(Nutrient::class,'meals_nutrients','meal_id','nutrient_id');
    }

    public function mealTime(){
        return $this->belongsTo(MealTime::class);
    }
    public function mealable()
    {
        return $this->morphTo();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('crop')
            ->fit(Manipulations::FIT_CROP, 150, 200)
            ->performOnCollections('meal_image_user')
            ->keepOriginalImageFormat();
        $this->addMediaConversion('crop')
            ->performOnCollections('meal_image_admin')
            ->keepOriginalImageFormat();
    }
}


