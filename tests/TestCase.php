<?php

namespace Bramin\CuttlyPHP\Tests;

use Bramin\CuttlyPHP\CuttlyPHPServiceProvider;
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
            CuttlyPHPServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
    }
}
