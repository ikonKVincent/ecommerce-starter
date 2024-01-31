<?php

namespace Database\Factories;

use App\Models\Pages\PageType;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageTypeFactory extends Factory
{
    protected $model = PageType::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
        ];
    }
}
