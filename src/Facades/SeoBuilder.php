<?php

namespace Codedor\Seo\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void tag(\Codedor\Seo\Tags\Tag $item)
 * @method static void tags(array $items, bool $overwrite = true)
 * @method static string render()
 * @method static object getTags()
 * @method static string getTag(string $tagName)
 *
 * @see \Codedor\Seo\SeoBuilder
 */
class SeoBuilder extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'seo';
    }
}
