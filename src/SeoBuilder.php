<?php

namespace Codedor\Seo;

use Codedor\Seo\Models\SeoRoute;
use Codedor\Seo\Tags\Tag;

class SeoBuilder
{
    /** var Collection */
    public $items;

    /**
     * Create a new SeoBuilder instance
     *
     * @return void
     */
    public function __construct()
    {
        $this->items = collect([]);
    }

    /**
     * Add a tag to the items
     */
    public function tag(Tag $item): void
    {
        // Use key as unique identifier, so we can't add multiple tags with same name/property
        $this->items->put($item->getIdentifier(), $item);
    }

    /** Convert arrays with key: type, name, content to a tag class */
    public function tags(array $items, bool $overwrite = true)
    {
        collect($items)
            ->map(fn (array $item) => $item['type']::make(
                new SeoRoute(),
                $item['name']
            )->content($item['content']))
            ->each(function (Tag $tag) use ($overwrite) {
                $exists = $this->items->has($tag->getIdentifier());
                if (($exists && $overwrite) || ! $exists) {
                    $this->tag($tag);
                }
            });
    }

    /**
     * Render the tags
     */
    public function render(): string
    {
        $this->setDefaults();

        return $this->items
            ->map->render()
            ->implode(' ');
    }

    /**
     * Set the default tags from the seo config
     *
     * @return void
     */
    protected function setDefaults()
    {
        $this->tags(config('seo.default', []), false);
    }
}
