<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Contracts\Activity as SpatieActivity;
use Spatie\Translatable\HasTranslations;

use App\Models\UserSubscriptionSession;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Meet extends Model
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
        'type_id',
        'start_at',
        'end_at',
        'status',
        'join_code'
    ];

    protected $translatable = [];

    protected $casts = [
        'start_at'=>'datetime',
        'end_at'=>'datetime',
    ];
    public function sessions():HasMany
    {
        return $this->hasMany(UserSubscriptionSession::class, 'meet_id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function session()
    {
        return $this->hasOne(UserSubscriptionSession::class);
    }

    public function comments(){
        return $this->hasMany(MeetComment::class);
    }

    public function tapActivity(SpatieActivity $activity, string $eventName)
    {
        $activity->log_name = 'Meet';

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
            'type_id',
            'start_at',
            'end_at',
        ]);
    }
}


