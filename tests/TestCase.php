<?php

namespace Bramin\CuttlyPHP\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use Bramin\CuttlyPHP\CuttlyPHPServiceProvider;

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
    {}
}
