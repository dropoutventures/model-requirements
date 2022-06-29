<?php

namespace DropoutVentures\ModelRequirements\Tests\Database\factories;

use DropoutVentures\ModelRequirements\Tests\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    protected $model = Brand::class;

    public function definition()
    {
        return [
            'title' => $this->faker->company,
            'domain' => $this->faker->domainName,
        ];
    }
}
