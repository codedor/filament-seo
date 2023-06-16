<?php

use Codedor\Seo\Tags\OgUrl;
use Codedor\Seo\Tags\Tag;

it('can construct a class', function () {
    expect(new OgUrl('key', 'content'))
        ->toBeInstanceOf(Tag::class);
});

it('has a meta identifier prefix', function () {
    expect(new OgUrl('key', 'content'))
        ->content()->toBe('http://localhost');
});
