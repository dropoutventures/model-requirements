<?php

namespace DropoutVentures\ModelRequirements\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use DropoutVentures\ModelRequirements\Models\Requirement;

trait OwnsRequirements
{
    /**
     * @return MorphMany
     */
    public function requirements(): MorphMany
    {
        return $this->morphMany(Requirement::class, 'parent');
    }
}
