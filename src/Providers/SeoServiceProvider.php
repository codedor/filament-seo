<?php

namespace Codedor\Seo\Providers;

use Codedor\Seo\Console\Commands\ImportSeoRoutes;
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
            ->hasMigration('update_translatable_to_seo_fields')
            ->hasConsoleCommand(ImportSeoRoutes::class)
            ->runsMigrations();
    }

    public function packageBooted()
    {
        $this->app->bind('seo', function () {
            return new \Codedor\Seo\SeoBuilder();
        });
    }
}
