<?php

namespace Codedor\Seo;

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
        $this->items->put($item->identifier(), $item);
    }

    /**
     * Add multiple tags to the items
     */
    public function tags(array $items): void
    {
        collect($items)
            ->each(function ($tag) {
                $this->tag($tag);
            });
    }

    /**
     * Render the tags
     */
    public function render(): string
    {
        $this->setDefaults();

        return $this->items
            ->map(fn (Tag $tag) => $tag->render())
            ->implode('');
    }

    /**
     * Return the tags as collection
     */
    public function getTags(): object
    {
        return $this->items
            ->map(fn ($tag) => $tag->content());
    }

    /**
     * Return the tag content
     *
     * @param  string  $tagName (like 'meta_title')
     */
    public function getTag($tagName): string
    {
        return isset($this->items[$tagName]) ? $this->items[$tagName]->content() : '';
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
