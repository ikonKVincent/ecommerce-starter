<?php

namespace Database\Factories;

use App\Models\Pages\Page;
use App\Models\Settings\Language;
use App\Models\Settings\Url;
use Illuminate\Database\Eloquent\Factories\Factory;

class UrlFactory extends Factory
{
    protected $model = Url::class;

    public function definition(): array
    {
        return [
            'slug' => $this->faker->slug,
            'default' => true,
            'language_id' => Language::factory(),
            'element_type' => Page::class,
            'element_id' => 1,
        ];
    }
}
