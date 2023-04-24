<?php

namespace Codedor\Seo\Tags;

class OgUrl extends OpenGraph
{
    protected $key = 'url';

    public function content(bool $raw = false): string
    {
        return request()->fullUrl();
    }
}
