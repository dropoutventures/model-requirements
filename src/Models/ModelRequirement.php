<?php

namespace DropoutVentures\ModelRequirementSettings\Models;

use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModelRequirement extends MorphPivot
{
    protected $casts = [
        'relationships' => 'collection',
        'match' => 'collection',
    ];

    /**
     * @return BelongsTo
     */
    public function requirement(): BelongsTo
    {
        return $this->belongsTo(Requirement::class);
    }
}
