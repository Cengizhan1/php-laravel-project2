<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;

class MealNutrient extends Model
{
    use LogsActivity;
    use HasFactory;

    protected $fillable=[
        'meal_id',
        'nutrient_id',
        'is_consumed',
        'quantity',
        'alternative_nutrient_id',
    ];
    protected $casts=[
        'crated_at'=>'datetime'
    ];
    protected $table='meals_nutrients';

    public function meal(){
        return $this->belongsTo(Meal::class,'meal_id');
    }
    public function nutrient(){
        return $this->belongsTo(Nutrient::class,'nutrient_id');
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->log_name = 'MealNutrient';

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
            'meal_id',
            'nutrient_id',
            'is_consumed',
            'alternative_nutrient_id',
        ]);
    }
}
