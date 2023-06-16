<?php

use Codedor\Seo\Tags\Tag;
use Codedor\Seo\Tags\Meta;

it('can construct a class', function () {
    expect(new Meta('key', 'content'))
        ->toBeInstanceOf(Tag::class);
});

it('has a meta identifier prefix', function () {
    expect(new Meta('key', 'content'))
        ->identifier()->toBe('meta_key');
});
