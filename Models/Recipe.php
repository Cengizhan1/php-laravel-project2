<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;

class Recipe extends Model
{
    use LogsActivity;
    use HasFactory;
    use HasTranslations;
    use SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'admin_id',
        'recipe_category_id',
        'message',
    ];

    protected $translatable = [
        'name',
//        'description',
    ];

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->log_name = 'Recipe';

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
            'recipe_category_id',
            'message',
        ]);
    }

    public function admin(){
        return $this->belongsTo(Admin::class);
    }
    public function category(){
        return $this->belongsTo(RecipeCategory::class);
    }
    public function nutrient(){
        return $this->belongsToMany(Nutrient::class,'recipes_nutrients');
    }
}


