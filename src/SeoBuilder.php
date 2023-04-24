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
    public function tags(array $items, bool $overwrite = true): void
    {
        collect($items)
            ->filter(function ($field) {
                return isset($field['type']);
            })
            ->map(function ($field) {
                $class = $field['type'];

                return new $class($field['name'], $field['content']);
            })
            ->filter(function ($item) use ($overwrite) {
                if (! $overwrite) {
                    $identifier = $item->identifier();

                    if ($this->items->has($identifier) && $this->items->get($identifier)->content()) {
                        return false;
                    }
                }

                return true;
            })
            ->each(function ($tag) {
                if ($tag && $tag->content()) {
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
            ->map(function ($tag) {
                return $tag->render();
            })
            ->implode('');
    }

    /**
     * Return the tags as collection
     */
    public function getTags(): object
    {
        return $this->items
            ->map(function ($tag) {
                return $tag->content();
            });
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
