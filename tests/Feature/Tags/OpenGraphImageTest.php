<?php

use Codedor\Seo\Tags\Tag;
use Codedor\Seo\Tags\OpenGraphImage;


it('can construct a class', function () {
    expect(new OpenGraphImage('key', 'content'))
        ->toBeInstanceOf(Tag::class);
});

it('will return content as is in the beforeSave', function () {
    $content = fake()->realTextBetween(280, 300);

    expect(new OpenGraphImage('key', $content))
        ->beforeSave($content)->toBe($content);
});

it('returns empty string if content is null', function () {
    expect(new OpenGraphImage('key', null))
        ->content()->toBe('');
});

it('can return the raw content', function () {
    expect(new OpenGraphImage('key', 'content'))
        ->content(true)->toBe('content');
});

it('can return the content', function () {
    expect(new OpenGraphImage('key', 'content'))
        ->content()->toBe('content');
});
