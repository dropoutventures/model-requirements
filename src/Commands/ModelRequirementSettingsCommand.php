<?php

namespace DropoutVentures\ModelRequirementSettings\Commands;

use Illuminate\Console\Command;

class ModelRequirementSettingsCommand extends Command
{
    public $signature = 'model-requirement-settings';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
