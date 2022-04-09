<?php

namespace Bramin\CuttlyLaravel\Tests;

use Bramin\CuttlyLaravel\CuttlyLaravelServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            CuttlyLaravelServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
    }
}
