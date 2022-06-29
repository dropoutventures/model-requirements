<?php

namespace DropoutVentures\ModelRequirements\Tests\Models;

use DropoutVentures\ModelRequirements\Models\Requirement;
use DropoutVentures\ModelRequirements\Tests\Database\factories\IntegrationFactory;
use DropoutVentures\ModelRequirements\Traits\OwnsRequirements;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Integration extends Model
{
    use HasFactory;
    use OwnsRequirements;

    protected $guarded = [];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function actions()
    {
        return $this->hasMany(Action::class);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return IntegrationFactory::new();
    }
}
