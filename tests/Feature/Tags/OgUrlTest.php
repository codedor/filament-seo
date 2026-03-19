<?php

use Wotz\Seo\Tags\OgUrl;
use Wotz\Seo\Tags\Tag;
use Wotz\Seo\Tests\Fixtures\Models\Page;

it('can construct a class', function () {
    expect(new OgUrl(new Page, 'key', 'content'))
        ->toBeInstanceOf(Tag::class);
});

it('has a meta identifier prefix', function () {
    expect(new OgUrl(new Page, 'key', 'content'))
        ->getContent()->toBe('http://localhost');
});
