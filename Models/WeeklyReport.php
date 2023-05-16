<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;

class WeeklyReport extends Model
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
        'report_id',
        'session_id',
        'date',
    ];

    protected $translatable = [
//        'name',
//        'description',
    ];
    protected $casts = [
        'date' => 'datetime',
    ];

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->log_name = 'WeeklyReport';

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
                'report_id',
                'date',
            ]);
    }

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

}


