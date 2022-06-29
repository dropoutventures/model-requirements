<?php

namespace DropoutVentures\ModelRequirements\Tests\Database\factories;

use DropoutVentures\ModelRequirements\Tests\Models\Input;
use Illuminate\Database\Eloquent\Factories\Factory;

class InputFactory extends Factory
{
    protected $model = Input::class;

    public function definition()
    {
        return [
            'label' => $this->faker->jobTitle,
            'type' => $this->faker->randomElement(['text','radio','checkbox']),
        ];
    }
}
