<?php

namespace DropoutVentures\ModelRequirementSettings\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Requirement extends Model
{
    use HasFactory;

    protected $casts = [
        'isRelationship' => 'boolean',
    ];

    /**
     * @return MorphTo
     */
    public function parent(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return HasMany
     */
    public function models(): HasMany
    {
        return $this->hasMany(ModelRequirement::class);
    }
}
