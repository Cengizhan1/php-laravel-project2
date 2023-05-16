<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;
use App\Models\User;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;

use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Allergy extends Model implements Searchable
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
        'description',
    ];

    protected $translatable = [
        'name',
        'description',
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

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->log_name = 'Allergy';

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
            'description',
        ]);
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\belongsToMany
    {
        return $this->belongsToMany(User::class, 'users_allergies');
    }
}


