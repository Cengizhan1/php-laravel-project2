<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;

class DietCategory extends Model
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
        'type',
        'admin_id',

    ];
    protected $translatable = [
        'name',
//        'description',
    ];
    public function admin(){
        return $this->belongsTo(Admin::class);
    }
    public function diets(){
        return $this->hasMany(Diet::class);
    }
    public function templateDiets(){
        return $this->hasMany(TemplateDiet::class);
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->log_name = 'DietCategory';

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
            'admin_id',
        ]);
    }
}


