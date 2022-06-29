<?php

namespace DropoutVentures\ModelRequirements\Tests\Database\factories;

use DropoutVentures\ModelRequirements\Tests\Models\Integration;
use Illuminate\Database\Eloquent\Factories\Factory;

class IntegrationFactory extends Factory
{
    protected $model = Integration::class;

    public function definition()
    {
        return [
            'name' => $this->faker->jobTitle,
            'class' => $this->faker->slug,
        ];
    }
}
