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
                ->identifier()->toBe('title'),
            fn ($tag) => $tag
                ->toBeInstanceOf(BaseTag::class)
                ->identifier()->toBe('description'),
        );
});
