<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MealCategory>
 */
class MealCategoryFactory extends Factory
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
        return [
            'title' => $title,
            'slug' => Str::slug($titleHr, '-'),
        ];
    }
}
