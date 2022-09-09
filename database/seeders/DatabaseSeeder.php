<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Language;
use App\Models\MealCategory;
use App\Models\MealIngredient;
use App\Models\MealItem;
use App\Models\MealTag;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Language::create([
            'lang' => 'hr'
        ]);
        Language::create([
            'lang' => 'en'
        ]);
        MealCategory::factory(5)->create();
        MealIngredient::factory(10)->create();
        MealTag::factory(10)->create();
        MealItem::factory(30)->create();
        $tags = MealTag::all()->pluck('id');
        $ingredients = MealIngredient::all()->pluck('id');
        foreach(MealItem::all() as $meal){
            $randomNumber = rand(1,3);
            $i = $ingredients->random($randomNumber);
            $t = $tags->random($randomNumber);
            $meal->MealIngredient()->sync($i);
            $meal->MealTag()->sync($t);
        }
    }
}
