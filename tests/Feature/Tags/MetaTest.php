<?php

use Codedor\Seo\Tags\Meta;
use Codedor\Seo\Tags\Tag;

it('can construct a class', function () {
    expect(new Meta('key', 'content'))
        ->toBeInstanceOf(Tag::class);
});

it('has a meta identifier prefix', function () {
    expect(new Meta('key', 'content'))
        ->identifier()->toBe('meta_key');
});
