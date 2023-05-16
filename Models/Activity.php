<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity as SpatieActivity;

use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Activity extends Model implements Searchable
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
        'name',
        'calorie',
        'weight_settings',
    ];

    protected $appends = [
        'special_calorie'
    ];

    public function getSearchResult(): SearchResult
    {
        $url = $this->id;
        return new SearchResult(
            $this,
            $this->name,
            $url
        );
    }

    public function tapActivity(SpatieActivity $activity, string $eventName)
    {
        $activity->log_name = 'Activity';

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
        ->logOnly(['name', 'calorie', 'weight_settings']);
    }

    public function getSpecialCalorieAttribute(){
        return null;
        $weight = auth()->user()->information->first()->weight;
        $settings = $this->weight_settings;
        foreach ($settings as $setting){
            if($weight <= $setting['max'] && $weight >= $setting['min']){
                return $setting['per_minute'];
            }
        }
    }

    protected $translatable = [
        'name',
//        'description',
    ];

    protected $casts = [
        'weight_settings' => 'json',
    ];

    public function userCalories(){
        return $this->hasMany(UserCalorie::class);
    }
}


