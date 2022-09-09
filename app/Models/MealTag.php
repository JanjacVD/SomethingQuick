<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class MealTag extends Model
{
    use HasFactory, HasTranslations, SoftDeletes;
    protected $fillable = ['title', 'slug'];
    protected $hidden = ['pivot'];
    public $translatable = ['title'];
    public function MealItem()
    {
        return $this->belongsToMany(MealItem::class, 'meal_tag_meal_item');
    }
}
