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
        //To prevent undefined relations
        if (in_array('tags', $this->with)) {
            array_push($withParam, 'MealTag');
        }

        if (in_array('ingredients', $this->with)) {
            array_push($withParam, 'MealIngredient');
        }

        if (in_array('category', $this->with)) {
            array_push($withParam, 'MealCategory');
        }

        //Check wether we need trashed items
        if (!isset($this->time)) {
            $meals = MealItem::withoutTrashed();
        } else {
            $meals = MealItem::withTrashed();
        }

        $meals = $meals->with($withParam);
        //Filter by tags
        $t = explode(',', $this->tags);

        $tags = MealTag::findMany($t)->pluck('id');

        $meals = $meals->whereHas('MealTag', function ($q) use ($tags) {
            $q->whereIn('id', $tags);
        }, '>=', count($tags))->has('MealIngredient');

        //Filter the time
        $meals = $this->filterTime($meals);
        //Filter the category
        $meals = $this->filterCategory($meals);
        //Return to controller
        return $meals;
    }
    private function filterCategory($meals)
    {
        if ($this->category === null) {
            //Since if we send null it will be a string
            return $meals;
        }

        switch ($this->category) {
            case 'null':
                $meals = $meals->where('meal_category_id', NULL);
                break;
            case '!null':
                $meals = $meals->whereNotNull('meal_category_id');
                break;
            default:
                $meals = $meals->where('meal_category_id', $this->category);
                break;
        }
        //Return the filtered value
        return $meals;
    }

    private function filterTime($meals)
    {
        //Check wether we actually need to filter
        if ($this->time === null) {
            return $meals;
        }

        $date = Carbon::createFromTimestamp($this->time)->format('Y-m-d h:i:s');

        $meals = $meals->where(function ($q) use ($date) {
            $q->where('created_at', '>=', $date)
                ->orWhere('deleted_at', '>=', $date)
                ->orWhere('created_at', '>=', $date);
        });

        return $meals;
    }
}
