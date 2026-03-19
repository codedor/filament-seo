<?php

use Wotz\Seo\Tags\Meta;
use Wotz\Seo\Tags\Tag;
use Wotz\Seo\Tests\Fixtures\Models\Page;

it('can construct a class', function () {
    expect(new Meta(new Page, 'key', 'content'))
        ->toBeInstanceOf(Tag::class);
});

it('has a meta identifier prefix', function () {
    expect(new Meta(new Page, 'key', 'content'))
        ->getIdentifier()->toBe('meta_key');
});
