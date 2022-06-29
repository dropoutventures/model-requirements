<?php

namespace DropoutVentures\ModelRequirements\Tests\Models;

use DropoutVentures\ModelRequirements\Tests\Database\factories\IntegrationFactory;
use DropoutVentures\ModelRequirements\Tests\Database\factories\TeamFactory;
use DropoutVentures\ModelRequirements\Traits\HasRequirements;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function integrations()
    {
        return $this->hasMany(Integration::class);
    }

    public function brands()
    {
        return $this->hasMany(Brand::class);
    }

    public function themes()
    {
        return $this->hasMany(Theme::class);
    }

    public function inputs()
    {
        return $this->hasMany(Input::class);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return TeamFactory::new();
    }
}
