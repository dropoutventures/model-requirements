<?php

namespace DropoutVentures\ModelRequirementSettings\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \DropoutVentures\ModelRequirementSettings\ModelRequirementSettings
 */
class ModelRequirementSettings extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'model-requirement-settings';
    }
}
