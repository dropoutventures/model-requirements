<?php

namespace DropoutVentures\ModelRequirements\Traits;

use DropoutVentures\ModelRequirements\Models\Requirement;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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
