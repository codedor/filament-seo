<?php

namespace Codedor\Seo\Models\Traits;

use Codedor\Seo\Models\SeoField;
use Codedor\Seo\SeoBuilder as SeoSeoBuilder;
use Codedor\Seo\SeoFieldOptions;
use Illuminate\Database\Eloquent\Model;

trait HasSeoFields
{
    public static function bootHasSeoFields()
    {
        static::deleting(function (Model $entity) {
            $entity->seoFields()->get()->each->delete();
        });

        static::saving(function (Model $entity) {
            return $entity->saveSeoFields();
        });
    }

    /**
     * Set the polymorphic relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function seoFields()
    {
        return $this->morphMany(SeoField::class, 'model');
    }

    /**
     * Get all seo fields.
     */
    public function withSeoFields()
    {
        SeoSeoBuilder::tags($this->seoFields->toArray());
    }

    public function getSeoOptions(): SeoFieldOptions
    {
        return SeoFieldOptions::create();
    }

    public function saveSeoFields()
    {
        $seoFields = $this->getSeoFieldOptions()->list($this);

        $seoEntities = [];

        $seoFields->filter(function ($seoField) {
            return array_key_exists($seoField->identifier(), $this->toArray());
        })
            ->each(function ($seoField) use (&$seoEntities) {
                $content = $this->getAttribute($seoField->identifier());
                unset($this->{$seoField->identifier()});

                $defaultAttribute = $seoField->settings('default');

                if ((! $content || $content === 'null') && $defaultAttribute) {
                    $content = $this->getAttribute($defaultAttribute)
                        // Check if the user didn't fill in a field name by accident
                        // 'online' for example
                        ?? array_key_exists($defaultAttribute, $this->toArray())
                            ? null
                            : $defaultAttribute;
                }

                $seoEntities[] = [
                    'attributes' => [
                        'type' => get_class($seoField),
                        'name' => $seoField->key(),
                    ],
                    'values' => [
                        'content' => $seoField->beforeSave($content),
                    ],
                ];
            });

        if (! empty($seoEntities)) {
            $this->save();

            foreach ($seoEntities as $seoEntity) {
                $this->seoFields()->updateOrCreate(
                    $seoEntity['attributes'],
                    $seoEntity['values']
                );
            }
        }

        return $this;
    }

    public function initSeo()
    {
        $seoFields = $this->getSeoFieldOptions()->list($this);

        $seoEntities = [];

        $seoFields->each(function ($seoField) use (&$seoEntities) {
            $defaultAttribute = $seoField->settings('default');
            $content = null;

            if ($defaultAttribute) {
                $content = $this->getAttribute($defaultAttribute)
                    // Check if the user didn't fill in a field name by accident
                    // 'online' for example
                    ?? (array_key_exists($defaultAttribute, $this->toArray())
                        ? null
                        : $defaultAttribute);
            }

            $seoEntities[] = [
                'attributes' => [
                    'type' => get_class($seoField),
                    'name' => $seoField->key(),
                ],
                'values' => [
                    'content' => $seoField->beforeSave($content),
                ],
            ];
        });

        if (! empty($seoEntities)) {
            foreach ($seoEntities as $seoEntity) {
                $this->seoFields()->updateOrCreate(
                    $seoEntity['attributes'],
                    $seoEntity['values']
                );
            }
        }

        return $this;
    }
}
