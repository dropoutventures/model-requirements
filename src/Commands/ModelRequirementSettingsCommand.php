<?php

namespace DropoutVentures\ModelRequirements\Commands;

use Illuminate\Console\Command;

class ModelRequirementsCommand extends Command
{
    public $signature = 'model-requirements';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
