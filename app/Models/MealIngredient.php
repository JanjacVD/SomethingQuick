<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class MealIngredient extends Model
{
    use HasFactory, HasTranslations, SoftDeletes;
    protected $fillable = ['title', 'slug'];
    public $translatable = ['title'];
    protected $hidden = ['pivot'];
    public function MealItem()
    {
        return $this->belongsToMany(MealItem::class, 'meal_ingredient_meal_item');
    }
}
