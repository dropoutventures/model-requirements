<?php

namespace DropoutVentures\ModelRequirements;

use DropoutVentures\ModelRequirements\Commands\ModelRequirementsCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ModelRequirementsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('model-requirements')
            ->hasConfigFile()
            ->hasMigration('create_requirements_table')
            ->hasCommand(ModelRequirementsCommand::class);
    }
}
