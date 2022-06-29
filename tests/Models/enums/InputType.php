<?php

namespace DropoutVentures\ModelRequirements\Tests\Models\enums;

enum InputType: string
{
    case Text = 'text';
    case Number = 'number';
    case Select = 'dropdown';
    case Radio = 'radio';
    case Checkbox = 'checkbox';
    case Hidden = 'hidden';
    case Phone = 'phone';
    case Email = 'email';
}
