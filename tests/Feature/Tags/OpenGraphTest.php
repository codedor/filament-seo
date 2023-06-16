<?php

use Codedor\Seo\Tags\Tag;
use Codedor\Seo\Tags\OpenGraph;

it('can construct a class', function () {
    expect(new OpenGraph('key', 'content'))
        ->toBeInstanceOf(Tag::class);
});

it('has an attribute', function () {
    expect(new OpenGraph('key', 'content'))
        ->render()->toBe('<meta property="og:key" content="content">');
});

it('has an og: prefix', function () {
    expect(new OpenGraph('key', 'content'))
        ->prefixedKey()->toBe('og:key');
});

it('has an og_ identifier prefix', function () {
    expect(new OpenGraph('key', 'content'))
        ->identifier()->toBe('og_key');
});
