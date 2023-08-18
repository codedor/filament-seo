<?php

namespace Codedor\Seo\Filament;

use Codedor\Seo\Filament\Resources\SeoRouteResource;
use Filament\Contracts\Plugin;
use Filament\Panel;

class SeoPlugin implements Plugin
{
    protected bool $hasSeoRouteResource = true;

    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'codedor/filament-seo';
    }

    public function register(Panel $panel): void
    {
        if ($this->hasSeoRouteResource()) {
            $panel->resources([
                SeoRouteResource::class,
            ]);
        }
    }

    public function boot(Panel $panel): void
    {

    }

    public function seoRouteResource(bool $condition = true): static
    {
        $this->hasSeoRouteResource = $condition;

        return $this;
    }

    public function hasSeoRouteResource(): bool
    {
        return $this->hasSeoRouteResource;
    }
}
