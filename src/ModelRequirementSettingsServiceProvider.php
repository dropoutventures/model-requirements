<?php

namespace DropoutVentures\ModelRequirementSettings;

use DropoutVentures\ModelRequirementSettings\Commands\ModelRequirementSettingsCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ModelRequirementSettingsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('model-requirement-settings')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_model-requirement-settings_table')
            ->hasCommand(ModelRequirementSettingsCommand::class);
    }
}
