<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class MealCategory extends Model
{
    use HasFactory, HasTranslations, SoftDeletes;
    public $translatable = ['title'];
    protected $fillable = ['title', 'slug'];

    public function MealItem()
    {
        return $this->hasMany(MealItem::class);
    }
}
