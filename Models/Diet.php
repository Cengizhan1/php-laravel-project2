<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;

class Diet extends Model
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
        'admin_id',
        'package_type', // enum
        'date',
        'diet_category_id',
        'see_calorie',
        'user_id',
        'message',
        'status', // Enum active or passive
        'user_subscription_id',
        'is_face_2_face', //enum
    ];

    protected $translatable = [
        'name',
//        'description',
    ];
    protected $casts = [
        'date'=>'date'
    ];

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->log_name = 'Diet';

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
            'package_type', // enum
            'date',
            'diet_category_id',
            'see_calorie',
            'user_id',
            'message',
            'status', // Enum active or passive
            'user_subscription_id',
            'is_face_2_face', //enum
        ]);
    }

    public function meals()
    {
        return $this->morphMany('App\Models\Meal', 'mealable',   'relation_type',
        'relation_id');
    }
    public function admin(){
        return $this->belongsTo(Admin::class);
    }
    public function subscription(){
        return $this->belongsTo(UserSubscription::class);
    }
    public function category(){
        return $this->belongsTo(DietCategory::class,'diet_category_id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }


}


