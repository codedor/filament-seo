<?php

use Codedor\Seo\SeoBuilder;
use Codedor\Seo\Tags\BaseTag;

// how will we render the seo tags????
beforeEach(function () {
    $this->seoBuilder = new SeoBuilder();
    $this->page = new \Codedor\Seo\Tests\Fixtures\Models\Page();
});

it('can add a tag', function () {
    $tag = new BaseTag($this->page, 'key', 'content', ['settings']);

    $this->seoBuilder->tag($tag);

    expect($this->seoBuilder->items)
        ->toHaveCount(1)
        ->first()->toBe($tag);
});

it('can add multiple tag', function () {
    $tagOne = new BaseTag($this->page, 'tag one', 'content');
    $tagTwo = new BaseTag($this->page, 'tag two', 'content');

    $this->seoBuilder->tags([$tagOne, $tagTwo]);

    expect($this->seoBuilder->items)
        ->toHaveCount(2)
        ->sequence(
            fn ($tag) => $tag
                ->toBeInstanceOf(BaseTag::class)
                ->getIdentifier()->toBe('tag_one'),
            fn ($tag) => $tag
                ->toBeInstanceOf(BaseTag::class)
                ->getIdentifier()->toBe('tag_two'),
        );
});

it('can add multiple tag and overwrite existing items', function () {
    $this->seoBuilder->tag(new BaseTag('tag_one', 'content one old', []));

    $tagOne = [
        'type' => BaseTag::class,
        'name' => 'tag_one',
        'content' => 'content one',
    ];

    $tagTwo = [
        'type' => BaseTag::class,
        'name' => 'tag_two',
        'content' => 'content two',
    ];

    $this->seoBuilder->tags([$tagOne, $tagTwo], true);

    expect($this->seoBuilder->items)
        ->toHaveCount(2)
        ->sequence(
            fn ($tag) => $tag
                ->toBeInstanceOf(BaseTag::class)
                ->identifier()->toBe('tag_one')
                ->content()->toBe('content one'),
            fn ($tag) => $tag
                ->toBeInstanceOf(BaseTag::class)
                ->identifier()->toBe('tag_two')
                ->content()->toBe('content two'),
        );
});

it('can add multiple tag and will not overwrite existing items', function () {
    $this->seoBuilder->tag(new BaseTag('tag_one', 'content one old', []));

    $tagOne = [
        'type' => BaseTag::class,
        'name' => 'tag_one',
        'content' => 'content one',
    ];

    $tagTwo = [
        'type' => BaseTag::class,
        'name' => 'tag_two',
        'content' => 'content two',
    ];

    $this->seoBuilder->tags([$tagOne, $tagTwo], false);

    expect($this->seoBuilder->items)
        ->toHaveCount(2)
        ->sequence(
            fn ($tag) => $tag
                ->toBeInstanceOf(BaseTag::class)
                ->identifier()->toBe('tag_one')
                ->content()->toBe('content one old'),
            fn ($tag) => $tag
                ->toBeInstanceOf(BaseTag::class)
                ->identifier()->toBe('tag_two')
                ->content()->toBe('content two'),
        );
});

it('can render', function () {
    $tag = new BaseTag('key', 'content', ['settings']);

    $this->seoBuilder->tag($tag);

    expect($this->seoBuilder)
        ->render()->toBe('<meta name="key" content="content">');
});

it('can render with defaults', function () {
    $defaultTag = [
        'type' => BaseTag::class,
        'name' => 'default',
        'content' => 'default content',
    ];

    config([
        'seo.default' => [$defaultTag],
    ]);

    $tag = new BaseTag('key', 'content', ['settings']);

    $this->seoBuilder->tag($tag);

    expect($this->seoBuilder)
        ->render()->toBe('<meta name="key" content="content"><meta name="default" content="default content">');
});

it('can get tags', function () {
    $tag = new BaseTag('key', 'content', ['settings']);

    $this->seoBuilder->tag($tag);

    expect($this->seoBuilder)
        ->getTags()->toArray()->toBe(['key' => 'content']);
});

it('can get tag', function () {
    $tag = new BaseTag('key', 'content', ['settings']);

    $this->seoBuilder->tag($tag);

    expect($this->seoBuilder)
        ->getTag('key')->toBe('content');
});
