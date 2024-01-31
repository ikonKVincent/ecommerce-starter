<?php

namespace Database\Factories;

use App\Models\Settings\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

class LanguageFactory extends Factory
{
    protected $model = Language::class;

    public function definition(): array
    {
        return [
            'default' => true,
            'code' => $this->faker->unique()->languageCode,
            'name' => $this->faker->name(),
        ];
    }
}
