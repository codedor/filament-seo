<?php

namespace Codedor\Seo\Tests;

use Codedor\Seo\Providers\SeoServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Codedor\\Seo\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            SeoServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->text('description');
        });

        $migrationFields = require __DIR__ . '/../database/migrations/create_seo_fields_table.php';
        $migrationRoutes = require __DIR__ . '/../database/migrations/create_seo_routes_table.php';

        $migrationFields->up();
        $migrationRoutes->up();
    }
}
