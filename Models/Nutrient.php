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

class Nutrient extends Model implements HasMedia
{
    use LogsActivity;
    use HasFactory;
    use HasTranslations;
    use InteractsWithMedia;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'unit',
        'calorie',
        'admin_id',
        'recipe_id',
        'vegan',
        'vegetarian',
        'description',
        'pregnant',
        'pregnant_week_information',
        'suckle',
        'suckle_week_information',
        'blood_group',
        'alternative_group_id',
        'date',
        'pregnant_time'
    ];

    protected $translatable = [
        'name',
        'description',
//        'description',
    ];
    protected $casts = [
        'date'=>'date',
        'pregnant_week_information'=>'array',
        'suckle_week_information'=>'array',
    ];

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->log_name = 'Nutrient';

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
            'name',
            'unit',
            'calorie',
            'admin_id',
            'recipe_id',
            'description',
            'vegan',
            'vegetarian',
            'pregnant',
            'suckle',
            'blood_group',
            'alternative_group_id',
            'date',
            'pregnant_time'
        ]);
    }

    public function admin(){
        return $this->belongsTo(Admin::class);
    }
    public function alternative_nutrients() {
        return Nutrient::where('alternative_group_id',$this->alternative_group_id)->whereNotNull('alternative_group_id')->
        where('id','!=',$this->id)->get();
    }

    public function recipe(){
        return $this->belongsTo(Recipe::class);
    }
    public function alergies_nutrients(){
        return $this->belongsToMany(Allergy::class,'allergies_nutrients','nutrient_id','allergy_id');
    }
    public function disease(){
        return $this->belongsToMany(Disease::class,'diseases_nutrients','nutrient_id','disease_id');
    }
    public function meals_nutrients(): BelongsToMany{
        return $this->belongsToMany(Meal::class,'meals_nutrients','nutrient_id','meal_id');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('crop')
            ->fit(Manipulations::FIT_CROP, 20, 20)
            ->performOnCollections('thumb')
            ->keepOriginalImageFormat();
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('thumb')
            ->useFallbackUrl('https://via.placeholder.com/' . (20) . 'x' . (20));

    }
}


