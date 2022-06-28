<?php

namespace DropoutVentures\ModelRequirements\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphPivot;

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
