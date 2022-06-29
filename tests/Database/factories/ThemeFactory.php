<?php

namespace DropoutVentures\ModelRequirements\Tests\Database\factories;

use DropoutVentures\ModelRequirements\Tests\Models\Theme;
use Illuminate\Database\Eloquent\Factories\Factory;

class ThemeFactory extends Factory
{
    protected $model = Theme::class;

    public function definition()
    {
        return [
            'name' => $this->faker->jobTitle,
            'folder' => $this->faker->slug,
        ];
    }
}
