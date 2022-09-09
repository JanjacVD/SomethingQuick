<?php

namespace App\Filter;

use App\Models\MealItem;
use App\Models\MealTag;
use Carbon\Carbon;

class MealFilter
{
    private $with;
    private $category;
    private $tags;
    private $time;

    function __construct($with, $category, $tags, $time)
    {
        $this->with = $with;
        $this->category = $category;
        $this->tags = $tags;
        $this->time = $time;
    }
    public function filter()
    {
        $withParam = [];

        if (in_array('tags', $this->with)) {
            array_push($withParam, 'MealTag');
        }
        if (in_array('ingredients', $this->with)) {
            array_push($withParam, 'MealIngredient');
        }
        if (in_array('category', $this->with)) {
            array_push($withParam, 'MealCategory');
        }
        if ($this->tags != null) {
            $t = explode(',', $this->tags);
            $tags = MealTag::findMany($t)->pluck('id');
            if ($this->time != null) {
                $meals = MealItem::withTrashed()->with($withParam)->orWhereHas('MealTag', function ($q) use ($tags) {
                    $q->whereIn('id', $tags);
                }, '>=', count($tags))->has('MealIngredient');
                $meals = $this->filterCategory($meals);
                $meals = $this->filterTime($meals);
            } else {
                $meals = MealItem::with($withParam)->orWhereHas('MealTag', function ($q) use ($tags) {
                    $q->whereIn('id', $tags);
                }, '>=', count($tags))->has('MealIngredient');
                $meals = $this->filterCategory($meals);
            }
        } else {
            if ($this->time != null) {
                $meals = MealItem::withTrashed()->with($withParam)->has('MealTag')->has('MealIngredient');
                $meals = $this->filterCategory($meals);

                $meals = $this->filterTime($meals);
            } else {
                $meals = MealItem::with($withParam)->has('MealTag')->has('MealIngredient');
                $meals = $this->filterCategory($meals);
            }
        }
        return $meals;
    }
    private function filterCategory($meals)
    {
        if ($this->category != null) {
            if ($this->category === 'null') {
                return $meals->where('meal_category_id', null);
            } else if ($this->category === '!null') {
                return $meals->where('meal_category_id', '!=', null);
            } else {
                return $meals->where('meal_category_id', $this->category);
            }
        } else {
            return $meals;
        }
    }
    private function filterTime($meals)
    {
        $date = Carbon::createFromTimestamp($this->time)->format('Y-m-d h:i:s');
        return $meals->where('deleted_at', '>=', $date)->orWhere('deleted_at', null);
    }
}
