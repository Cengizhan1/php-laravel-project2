<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use ObiPlus\ObiPlus\Models\Admin as AdminModel;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Relations\hasMany;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Relations\hasOne;
use App\Models\QuickMessage;

use App\Models\Role;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Admin extends AdminModel implements HasMedia
{
    use LogsActivity;
    use HasFactory;
    use HasApiTokens;
    use InteractsWithMedia;
    use Notifiable;
    use SoftDeletes;

    /**
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'status',
        'firebase_uid',
        'registration_completed',
        'last_activated_at',
        'email_verified_at',
        'firebase_device_token',
        'role_id',
        'modules',
    ];

    protected $casts = [
        'modules' => 'array'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly([
            'first_name',
            'last_name',
            'email',
            'password',
            'phone',
            'status',
            'firebase_uid',
            'registration_completed',
            'last_activated_at',
            'email_verified_at',
            'firebase_device_token',
            'role_id',
            'modules',
        ]);
    }

    public function role() {
        return $this->belongsTo(Role::class);
    }

    public function quickMessages() {
        return $this->hasMany(QuickMessage::class);
    }

    public function passwordValidate($password): bool
    {
        return Hash::check($password, $this->password);
    }

    public function scopeWhereActive($query)
    {
        $query->where('status', true);
    }
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('crop')
            ->nonQueued()
            ->fit(Manipulations::FIT_CROP, 64, 64)
            ->performOnCollections('avatar')
            ->keepOriginalImageFormat();
    }
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('avatar')
            ->useFallbackUrl('https://via.placeholder.com/'.(64).'x'.(64));
    }
}


