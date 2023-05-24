<?php

namespace Codedor\Seo\Facades;

use Illuminate\Support\Facades\Facade;

class SeoBuilder extends Facade
{
    /**
     * @see \App\SeoBuilder
     */
    protected static function getFacadeAccessor(): string
    {
        return 'seo';
    }
}
