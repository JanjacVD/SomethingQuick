<?php

namespace Database\Factories;

use App\Models\MealCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MealItem>
 */
class MealItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $titleHr = $this->faker->text(30).'hr';
        $title = ['hr' => $titleHr, 'en' => $this->faker->text(30).'en'];
        $descritpion = ['hr' => $this->faker->text(100), 'en' => $this->faker->text(100)];
        $cat = MealCategory::all()->random(1)->pluck('id');
        return [
            'title' => $title,
            'description' => $descritpion,
            'slug' => Str::slug($titleHr, '-'),
            'meal_category_id' => $cat[0]
        ];
    }
}
