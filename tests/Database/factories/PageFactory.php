<?php

namespace DropoutVentures\ModelRequirements\Tests\Database\factories;

use DropoutVentures\ModelRequirements\Tests\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageFactory extends Factory
{
    protected $model = Page::class;

    public function definition()
    {
        return [
            'title' => $this->faker->jobTitle,
            'slug' => $this->faker->slug,
        ];
    }
}
