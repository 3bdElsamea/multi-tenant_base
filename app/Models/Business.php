<?php

namespace App\Models;

use App\Observers\Central\BusinessObserver;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class Business extends Model implements TranslatableContract, HasMedia
{
    use HasFactory, SoftDeletes, Translatable, InteractsWithMedia;

    protected $table = 'businesses';
    public array $translatedAttributes = ['name', 'description'];

//    protected $fillable = ['is_active'];
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];

//#################### Accessors ####################
    public function getLogoAttribute(): string
    {
        $logo = $this->getFirstMedia('logo') ? $this->getFirstMedia('logo')->getFullUrl() :
            'GeneralAssets/Dashboard/images/avatars/avatar.png';
        return global_asset($logo);
    }

//#################### Mutators ####################

//#################### Scopes ####################
    public function scopeActive($query): void
    {
        $query->withoutTrashed()->where(['is_active' => 1]);
    }

    public function scopeTrashedById($query, $id): void
    {
        $query->onlyTrashed()->findOrFail($id);
    }
//#################### Relations ####################
//Busines super of type business
    public function manager(): HasOne
    {
        return $this->hasOne(User::class, 'business_id', 'id')->where('user_type', 'business_manager');
    }

    public function admins(): HasMany
    {
        return $this->hasMany(User::class, 'business_id', 'id')->where('user_type', 'business_admin');
    }

//#################### Methods ####################

//#################### Observers ####################
    public static function boot(): void
    {
        parent::boot();
        self::observe(new BusinessObserver());
    }
}
