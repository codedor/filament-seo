<?php

use Codedor\Seo\SeoFieldOptions;
use Codedor\Seo\Tags\BaseTag;
use Codedor\Seo\Tests\Fixtures\Models\Page;

beforeEach(function () {
    $this->seoFieldOptions = new SeoFieldOptions();
});

it('can make an instance', function () {
    expect(SeoFieldOptions::create())
        ->toBeInstanceOf(SeoFieldOptions::class);
});

it('can add a tag for a single type', function () {
    $this->seoFieldOptions->tag([
        'type' => BaseTag::class,
        'name' => 'base tag',
        'default' => 'default',
    ]);

    expect($this->seoFieldOptions)
        ->tags->toHaveCount(1);
});

it('can add a tag for multiple types', function () {
    $this->seoFieldOptions->tag([
        'type' => [BaseTag::class, BaseTag::class],
        'name' => 'base tag',
        'default' => 'default',
    ]);

    expect($this->seoFieldOptions)
        ->tags->toHaveCount(2);
});

it('can list the tags for a model', function () {
    $model = new Page();

    expect($model->getSeoFieldOptions()->list($model))
        ->sequence(
            fn ($tag) => $tag
                ->toBeInstanceOf(BaseTag::class)
                ->identifier()->toBe('title')
                ->content()->toBe(''),
            fn ($tag) => $tag
                ->toBeInstanceOf(BaseTag::class)
                ->identifier()->toBe('description')
                ->content()->toBe(''),
        );
});

it('can list the tags for a model with seo fields', function () {
    $page = Page::create([
        'title' => 'title',
        'description' => 'description',
    ]);

    $page->seoFields()->createMany([
        [
            'type' => BaseTag::class,
            'name' => 'title',
            'content' => 'seo title',
        ],
        [
            'type' => BaseTag::class,
            'name' => 'description',
            'content' => '',
        ],
    ]);

    expect($page->getSeoFieldOptions()->list($page))
        ->sequence(
            fn ($tag) => $tag
                ->toBeInstanceOf(BaseTag::class)
                ->identifier()->toBe('title')
                ->content()->toBe('seo title'),
            fn ($tag) => $tag
                ->toBeInstanceOf(BaseTag::class)
                ->identifier()->toBe('description')
                ->content()->toBe(''),
        );
});

it('can list the tags for a model with seo fields and falls back on default value', function () {
    $page = Page::create([
        'title' => 'title',
        'description' => 'description',
    ]);

    $page->seoFields()->createMany([
        [
            'type' => BaseTag::class,
            'name' => 'title',
            'content' => '',
        ],
        [
            'type' => BaseTag::class,
            'name' => 'description',
            'content' => '',
        ],
    ]);

    expect($page->getSeoFieldOptions()->list($page))
        ->sequence(
            fn ($tag) => $tag
                ->toBeInstanceOf(BaseTag::class)
                ->identifier()->toBe('title')
                ->content()->toBe('title'),
            fn ($tag) => $tag
                ->toBeInstanceOf(BaseTag::class)
                ->identifier()->toBe('description')
                ->content()->toBe(''),
        );
});
