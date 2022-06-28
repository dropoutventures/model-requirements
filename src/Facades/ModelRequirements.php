<?php

namespace DropoutVentures\ModelRequirements\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \DropoutVentures\ModelRequirements\ModelRequirements
 */
class ModelRequirements extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'model-requirements';
    }
}
