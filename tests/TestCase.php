<?php

namespace DropoutVentures\ModelRequirementSettings\Tests;

use DropoutVentures\ModelRequirementSettings\ModelRequirementSettingsServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'DropoutVentures\\ModelRequirementSettings\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            ModelRequirementSettingsServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $migration = include __DIR__.'/../database/migrations/create_requirements_table.php';
        $migration->up();
    }
}
