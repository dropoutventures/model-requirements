<?php

namespace DropoutVentures\ModelRequirements\Tests\Models;

use DropoutVentures\ModelRequirements\Tests\Database\factories\ThemeFactory;
use Illuminate\Database\Eloquent\Model;
use DropoutVentures\ModelRequirements\Traits\OwnsRequirements;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use DropoutVentures\ModelRequirements\Tests\Database\factories\IntegrationFactory;

class Theme extends Model
{
    use HasFactory;
    use OwnsRequirements;

    protected $guarded = [];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function brands()
    {
        return $this->hasMany(Brand::class);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return ThemeFactory::new();
    }
}
