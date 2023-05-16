<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Laravel\Passport\Client as ClientPassword;
use Laravel\Passport\HasApiTokens;
use Spatie\Image\Manipulations;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use App\Models\Disease;
use App\Models\Allergy;
use App\Models\HealthProblem;
use Spatie\Activitylog\Contracts\Activity;

class User extends Authenticatable implements HasMedia
{
    use LogsActivity;
    use HasTranslations;
    use InteractsWithMedia;
    use HasFactory;
    use HasApiTokens;
    use SoftDeletes;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'email',
        'gender',
        'birth_date',
        'firebase_uid',
        'registration_completed',
        'last_activated_at',
        'email_verified_at',
        'firebase_device_token',
        'can_compare_diets',
        'can_see_calorie',
        'is_those_who_no_not_continue',
        'photo_share_permission',
    ];

    protected $translatable = [
//        'name',
//        'description',
    ];
    protected $casts = [
        'birth_date' => 'datetime'
    ];

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->log_name = 'User';

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
            'id',
            'first_name',
            'last_name',
            'email',
            'gender',
            'birth_date',
            'firebase_uid',
            'registration_completed',
            'last_activated_at',
            'email_verified_at',
            'firebase_device_token',
            'can_compare_diets',
            'can_see_calorie',
            'food_photos_wanted'
        ]);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->timezone('Europe/Istanbul')->format("Y");
    }

    /**
     * Find the customer instance for the given username.
     *
     * @param string $username
     * @return \App\Models\User
     */
    public function findForPassport($username)
    {
        return $this->where('firebase_uid', $username)->first();
    }

    /**
     * Validate the password of the user for the Passport password grant.
     *
     * @param string $password
     * @return bool
     */
    public function validateForPassportPasswordGrant($password)
    {
        return Hash::check($password, $this->password);
    }

    public function health_problems(): \Illuminate\Database\Eloquent\Relations\belongsToMany
    {
        return $this->belongsToMany(HealthProblem::class, 'users_health_problems');
    }

    public function permission(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserNotificationPermission::class, 'user_id');
    }
    public function information(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserPersonalInformation::class, 'user_id');
    }
    public function waterConsumption(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserWaterConsumption::class, 'user_id');
    }
    public function activities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserCalorie::class, 'user_id');
    }
    public function notes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserNote::class, 'user_id');
    }
    public function callCenterNote(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CallResult::class, 'user_id');
    }
    public function diets(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Diet::class, 'user_id');
    }
    public function subscriptions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserSubscription::class, 'user_id');
    }
    public function addresses(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Address::class, 'user_id');
    }
    public function meets(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Meet::class, 'user_id');
    }

    public function activeSubscription(){
        return $this->subscriptions()->where('status',0)->first() ?? null;
    }

    public function pastSubscriptions(){
        return $this->subscriptions()?->where('status',1)->get();
    }

    public function measurements(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserMeasurement::class, 'user_id');
    }
    public function callResult(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CallResult::class, 'user_id');
    }
    public function getIsAddedBeforeAfterAttribute(){
        return $this->activeSubscription()?->sessions()?->orderBy('order','DESC')->first()?->getFirstMediaUrl('before_after') != null;
    }

    public function diseases(): \Illuminate\Database\Eloquent\Relations\belongsToMany
    {
        return $this->belongsToMany(Disease::class, 'users_diseases');
    }

    public function allergies(): \Illuminate\Database\Eloquent\Relations\belongsToMany
    {
        return $this->belongsToMany(Allergy::class, 'users_allergies');
    }

//    public function role(){
//        return $this->belongsTo(Role::class);
//    }

    public function scopeWhereAvailable($query)
    {
        $query->whereRegistrationCompleted(true);
    }


    public function colageImage(){
        $text = "YOUR  texttttttttttttttt";
        $second_image = imagecreate(100,200);
        $my_img = imagecreate( 200, 80 );                             //width & height
        $background  = imagecolorallocate( $my_img, 0,   0,   255 );
        $text_colour = imagecolorallocate( $my_img, 255, 255, 0 );
        imagestring( $my_img, 4, 80, 20, $text, $text_colour );
        imagesetthickness ( $my_img, 5 );
        $this->addMedia($my_img)->toMediaCollection('thumb');
        header( "Content-type: image/png" );
        imagepng( $my_img );
        return $second_image;
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

    public function routeNotificationForFcm($notification)
    {
        return $this->firebase_device_token;
    }
}
