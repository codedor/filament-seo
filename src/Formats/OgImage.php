<?php

namespace Codedor\Seo\Formats;

use Codedor\MediaLibrary\Formats\Format;
use Codedor\MediaLibrary\Formats\Manipulations;
use Codedor\Seo\Models\SeoRoute;
use Spatie\Image\Drivers\ImageDriver;
use Spatie\Image\Enums\Fit;

class OgImage extends Format
{
    protected string $name = 'OG Image';

    protected string $description = 'Format used to display the image for SEO purposes';

    public function definition(): Manipulations|ImageDriver
    {
        return $this->manipulations->fit(Fit::Contain, 1200, 630);
    }

    public function registerModelsForFormatter(): void
    {
        $this->registerFor(SeoRoute::class);
    }
}
