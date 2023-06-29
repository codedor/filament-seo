<?php

use Codedor\Seo\Tags\Meta;
use Codedor\Seo\Tags\Tag;

it('can construct a class', function () {
    expect(new Meta(new \Codedor\Seo\Tests\Fixtures\Models\Page(), 'key', 'content'))
        ->toBeInstanceOf(Tag::class);
});

it('has a meta identifier prefix', function () {
    expect(new Meta(new \Codedor\Seo\Tests\Fixtures\Models\Page(), 'key', 'content'))
        ->getIdentifier()->toBe('meta_key');
});
