<?php

namespace Codedor\Seo\Providers;

use Codedor\MediaLibrary\Facades\Models;
use Codedor\Seo\Console\Commands\ImportSeoRoutes;
use Codedor\Seo\Filament\Resources\SeoRouteResource;
use Codedor\Seo\Models\SeoRoute;
use Codedor\Seo\SeoBuilder;
use Illuminate\Support\Facades\Blade;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SeoServiceProvider extends PackageServiceProvider
{
    protected array $resources = [
        SeoRouteResource::class,
    ];

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

    public function packageBooted(): void
    {
        parent::packageBooted();

        $this->app->bind('seo', function () {
            return new SeoBuilder();
        });

        Models::add(SeoRoute::class);

        Blade::directive('seo', function (string $expression) {
            return "<?php echo \Codedor\Seo\Facades\SeoBuilder::render(); ?>";
        });
    }
}
