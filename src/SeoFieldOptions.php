<?php

namespace Codedor\Seo;

use Illuminate\Support\Collection;

class SeoFieldOptions
{
    /** @var array */
    public $tags;

    public static function create(): self
    {
        return new static();
    }

    public function tag(array $tag): self
    {
        if (is_array($tag['type'])) {
            foreach ($tag['type'] as $type) {
                $this->tag(array_merge($tag, ['type' => $type]));
            }
        } else {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function list($resource): Collection
    {
        $seoFields = $resource->seoFields;

        return collect($this->tags)->map(function ($field) use ($seoFields) {
            $seoField = $seoFields->first(function ($seoField) use ($field) {
                return $seoField->type === $field['type'] && $seoField->name === $field['name'];
            });

            $field['content'] = $seoField->content ?? null;

            if ($seoField && ! empty($field['default']) && ! $seoField->content) {
                $field['content'] = strip_tags($field['default']);
            }

            $class = $field['type'];

            $default = $field['default'] ?? null;

            return new $class($field['name'], $field['content'], compact('default'));
        });
    }
}
