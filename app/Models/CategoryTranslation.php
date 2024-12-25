<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class CategoryTranslation extends Model
{
    use HasTranslations;
    public $timestamps = false;
    protected $guarded = [];
}
