<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;

class City extends Model
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
        'country_id'
    ];

    protected $translatable = [
        'name',
    ];

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->log_name = 'City';

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
            'country_id'
        ]);
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }
}
