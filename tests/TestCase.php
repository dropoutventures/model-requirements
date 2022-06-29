<?php

namespace DropoutVentures\ModelRequirements\Tests;

use DropoutVentures\ModelRequirements\ModelRequirementsServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'DropoutVentures\\ModelRequirements\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            ModelRequirementsServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        $migration = include __DIR__.'/../database/migrations/create_requirements_table.php.stub';
        $migration->up();
        $migration = include __DIR__ . '/Database/create_test_models_table.php.stub';
        $migration->up();
    }
}
