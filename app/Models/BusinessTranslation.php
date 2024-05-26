<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessTranslation extends Model
{
    use HasFactory;

    protected $table = 'business_translations';

    protected $fillable = ['name', 'description'];

    protected $guarded = ['id', 'business_id', 'locale', 'created_at', 'updated_at'];
}
