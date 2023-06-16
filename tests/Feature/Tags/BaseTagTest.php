<?php

use Codedor\Seo\Tags\BaseTag;
use Codedor\Seo\Tags\Tag;
use Illuminate\Support\Str;

it('can construct a class', function () {
    expect(new BaseTag('key', 'content'))
        ->toBeInstanceOf(Tag::class);
});

it('can save content with a maximum length when length is longer than 255', function () {
    $content = fake()->realTextBetween(280, 300);

    $tag = new BaseTag('key', $content);

    expect($tag->beforeSave($content))
        ->toBe(Str::limit(strip_tags($content), 255, ''));
});

it('can save content with a maximum length when length is set in the rules', function () {
    config([
        'seo.rules.fields' => [
            'key' => [
                'max:125',
            ],
        ],
    ]);

    $content = fake()->realTextBetween(280, 300);

    $tag = new BaseTag('key', $content);

    expect($tag->beforeSave($content))
        ->toBe(Str::limit(strip_tags($content), 125, ''));
});

it('has an identifier', function () {
    expect(new BaseTag('key', 'content'))
        ->identifier()->toBe('key');
});

it('has a key', function () {
    expect(new BaseTag('key', 'content'))
        ->key()->toBe('key');
});

it('has a prefixed key', function () {
    expect(new BaseTag('key', 'content'))
        ->prefixedKey()->toBe('key');
});

it('has content', function () {
    expect(new BaseTag('key', 'content'))
        ->content()->toBe('content');
});

it('has settings', function () {
    expect(new BaseTag('key', 'content', ['settings']))
        ->settings()->toBe(['settings']);
});

it('can return a single setting', function () {
    expect(new BaseTag('key', 'content', ['settings' => 'value']))
        ->settings('settings')->toBe('value');
});

it('returns null when key is not found', function () {
    expect(new BaseTag('key', 'content', ['settings' => 'value']))
        ->settings('not-existing')->toBe(null);
});

it('can render', function () {
    expect(new BaseTag('key', 'content'))
        ->render()->toBe('<meta name="key" content="content">');
});

it('has no rules', function () {
    expect(new BaseTag('key', 'content'))
        ->rules()->toBe([]);
});

it('has a required rule when no default setting and seo.rules.default_empty_required is true', function () {
    config([
        'seo.rules.default_empty_required' => true,
    ]);

    expect(new BaseTag('key', 'content'))
        ->rules()->toBe(['required']);
});

it('has no required rule when no default setting and seo.rules.default_empty_required is true', function () {
    config([
        'seo.rules.default_empty_required' => false,
    ]);

    expect(new BaseTag('key', 'content'))
        ->rules()->toBe([]);
});

it('can set rules via the config', function () {
    config([
        'seo.rules.fields.key' => [
            'max:100',
            'required',
        ],
    ]);

    expect(new BaseTag('key', 'content'))
        ->rules()->toBe([
            'max:100',
            'required',
        ]);
});

it('has debug info', function () {
    expect(new BaseTag('key', 'content'))
        ->__debugInfo()->toBe([
            'identifier' => 'key',
            'key' => 'key',
            'content' => 'content',
            'settings' => [],
            'html' => '<meta name="key" content="content">',
        ]);
});
