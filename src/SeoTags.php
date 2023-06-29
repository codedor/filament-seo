<?php

namespace Codedor\Seo;

use Codedor\Seo\Models\SeoField;
use Codedor\Seo\Tags\BaseTag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class SeoTags extends Collection
{
    public function firstForTypeAndKey(string $type, string $key)
    {
        return $this->first(
            fn (BaseTag $tag) => $tag::class === $type && $tag->getKey() === $key
        );
    }
}
