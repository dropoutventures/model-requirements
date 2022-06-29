<?php

namespace DropoutVentures\ModelRequirements\Tests\Models;

use DropoutVentures\ModelRequirements\Models\Requirement;
use DropoutVentures\ModelRequirements\Tests\Database\factories\BrandFactory;
use DropoutVentures\ModelRequirements\Tests\Database\factories\IntegrationFactory;
use DropoutVentures\ModelRequirements\Traits\HasRequirements;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Brand extends Model
{
    use HasFactory;
    use HasRequirements;

    protected $guarded = [];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return BrandFactory::new();
    }
}
