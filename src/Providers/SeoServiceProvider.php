<?php

namespace Codedor\Seo\Providers;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SeoServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-seo')
            ->setBasePath(__DIR__ . '/../')
            ->hasConfigFile()
            ->hasMigration('create_seo_routes_table')
            ->hasMigration('create_seo_fields_table')
            ->runsMigrations();
    }

    public function packageBooted()
    {
        $this->app->bind('seo', function () {
            return new \Codedor\Seo\SeoBuilder();
        });
    }
}
