<?php

namespace Codedor\Seo\Filament\Resources\Pages;

use Codedor\Seo\Filament\Resources\SeoRouteResource;
use Codedor\TranslatableTabs\Resources\Traits\HasTranslations;
use Filament\Resources\Pages\EditRecord;

class EditSeoRoute extends EditRecord
{
    use HasTranslations;

    protected static string $resource = SeoRouteResource::class;
}
