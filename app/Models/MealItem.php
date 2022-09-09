<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class MealItem extends Model
{
    use HasFactory, HasTranslations, SoftDeletes;
    protected $fillable = ['title', 'description','slug'];
    public $translatable = ['title', 'description'];
    protected $hidden = ['pivot'];
    public function MealCategory()
    {
        return $this->belongsTo(MealCategory::class);
    }
    public function MealIngredient()
    {
        return $this->belongsToMany(MealIngredient::class, 'meal_ingredient_meal_item');
    }
    public function MealTag()
    {
        return $this->belongsToMany(MealTag::class, 'meal_tag_meal_item');
    }
}
