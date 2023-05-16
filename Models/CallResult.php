<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;

use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class CallResult extends Model implements Searchable
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
        'user_id',
        'admin_id',
        'call_result_state', // Enum
        'note',
        'date',
    ];
    protected $casts = [
        'date'=>'datetime'
    ];

    public function getSearchResult(): SearchResult
    {
        $url = $this->id;
        return new SearchResult(
            $this,
            $this->note,
            $url
        );
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->log_name = 'CallResult';

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
            'user_id',
            'admin_id',
            'call_result_state', // Enum
            'note',
        ]);
    }

    protected $translatable = [
//        'name',
//        'description',
    ];
    public function admin(){
        return $this->belongsTo(Admin::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}


