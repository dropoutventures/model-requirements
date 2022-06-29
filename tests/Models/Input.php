<?php

namespace DropoutVentures\ModelRequirements\Tests\Models;

use DropoutVentures\ModelRequirements\Models\Requirement;
use DropoutVentures\ModelRequirements\Tests\Database\factories\InputFactory;
use DropoutVentures\ModelRequirements\Tests\Database\factories\IntegrationFactory;
use DropoutVentures\ModelRequirements\Tests\Models\enums\InputType;
use DropoutVentures\ModelRequirements\Traits\HasRequirements;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Input extends Model
{
    use HasFactory;
    use HasRequirements;

    protected $guarded = [];

    protected $casts = [
      'type' => InputType::class
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return InputFactory::new();
    }
}
