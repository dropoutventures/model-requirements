<?php

namespace DropoutVentures\ModelRequirements\Tests\Database\factories;

use DropoutVentures\ModelRequirements\Tests\Models\Funnel;
use Illuminate\Database\Eloquent\Factories\Factory;

class FunnelFactory extends Factory
{
    protected $model = Funnel::class;

    public function definition()
    {
        return [
            'name' => $this->faker->jobTitle,
            'slug' => $this->faker->slug,
        ];
    }
}
