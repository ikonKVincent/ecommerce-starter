<?php

namespace Database\Factories;

use App\Models\Settings\AttributeGroup;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AttributeGroupFactory extends Factory
{
    private static $position = 1;

    protected $model = AttributeGroup::class;

    public function definition(): array
    {
        return [
            'attributable_type' => 'page_type',
            'name' => collect([
                'fr' => $this->faker->name(),
            ]),
            'handle' => Str::slug($this->faker->name()),
            'position' => self::$position++,
        ];
    }
}
