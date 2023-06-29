<?php

namespace Codedor\Seo\Formats;

use Codedor\Attachments\Formats\Format;

class OgImage extends Format
{
    protected string $description = 'Format used to display the image for SEO purposes';

    public function definition(): \Spatie\Image\Manipulations
    {
        return $this->manipulations
            ->fit(\Spatie\Image\Manipulations::FIT_CONTAIN, 1200, 630);
    }
}
