<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Exceptions\Custom\WrongPasswordException;
use App\Observers\Central\AdminObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject, HasMedia
{
    use HasFactory, Notifiable, SoftDeletes, InteractsWithMedia;

//    protected $fillable = ['name','email', 'password',]; // for mass assignment
    protected $hidden = ['password', 'remember_token', 'verification_code', 'password_reset_code',]; // to hide from json response
    protected $casts = ['email_verified_at' => 'datetime',];// to cast to a specific type
    protected $guarded = ['id', 'created_at', 'updated_at']; // to prevent mass assignment
    protected $with = ['media'];
    protected $appends = ['avatar'];

//#################### Accessors ####################

    public function getAvatarAttribute(): string
    {
        $avatar = $this->getFirstMedia('avatar') ? $this->getFirstMedia('avatar')->getFullUrl() :
            'GeneralAssets/Dashboard/images/avatars/avatar.png';
        return global_asset($avatar);
    }
//#################### Mutators ####################
    /**
     * Set the user's full_name attribute based on first_name and last_name
     */

//    protected function fullName(): Attribute
//    {
//        return Attribute::make('full_name', function () {
//            return $this->first_name . ' ' . $this->last_name;
//        });
//    }

    /**
     * Set the user's password.
     */
    protected function setPasswordAttribute($value): void
    {
        if ($value) {
            $this->attributes['password'] = bcrypt($value);
        }
    }
//#################### Scopes ####################

//#################### Relations ####################

//#################### Methods ####################
// Check old password
    public function checkOldPassword(string $oldPassword): void
    {
        if (!Hash::check($oldPassword, $this->password)) {
            throw new WrongPasswordException(__('dashboard.profile.incorrect_old_password'), 400);
        }
    }

//   Resolve Param Binding for types admin , business
    public function resolveRouteBinding($value, $field = null)
    {
        $user = $this->findOrFail($value);
        $routeParameter = array_key_first(Route::current()->parameters());
        abort_if($user->user_type !== $routeParameter, 404);
        return $user;
    }


//#################### JWT ####################

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     */
    public function getJWTIdentifier(): string
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }

//#################### Media Library ####################

//    public function registerMediaCollections(): void
//    {
//        $this->addMediaCollection('avatar')
//            ->singleFile();
//    }

//#################### Boot ####################
    protected static function boot(): void
    {
        parent::boot();
        self::observe(AdminObserver::class);
    }
}
