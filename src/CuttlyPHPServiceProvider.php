<?php

namespace Bramin\CuttlyPHP;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CuttlyPHPServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('cuttly')
            ->hasConfigFile('cuttly');

        $this->app->bind('cuttly', function()
        {
            return new Cuttly();
        });
    }
}
