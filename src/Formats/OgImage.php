<?php

namespace Codedor\Seo\Formats;

use Codedor\MediaLibrary\Formats\Format;
use Codedor\Seo\Models\SeoRoute;

class OgImage extends Format
{
    protected string $name = 'OG Image';

    protected string $description = 'Format used to display the image for SEO purposes';

    public function definition(): \Spatie\Image\Manipulations
    {
        return $this->manipulations
            ->fit(\Spatie\Image\Manipulations::FIT_CONTAIN, 1200, 630);
    }

    public function registerModelsForFormatter(): void
    {
        $this->registerFor(SeoRoute::class);
    }
}
