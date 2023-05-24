<?php

use Codedor\Seo\Tags\Meta;
use Codedor\Seo\Tags\OgUrl;
use Codedor\Seo\Tags\OpenGraph;
use Codedor\Seo\Tags\OpenGraphImage;

// config for Codedor/Seo
return [
    'default' => [
        'title_og' => [
            'type' => OpenGraph::class,
            'name' => 'title',
            'content' => config('app.name'),
        ],
        'title_meta' => [
            'type' => Meta::class,
            'name' => 'title',
            'content' => config('app.name'),
        ],
        'description_og' => [
            'type' => OpenGraph::class,
            'name' => 'description',
            'content' => '',
        ],
        'description_meta' => [
            'type' => Meta::class,
            'name' => 'description',
            'content' => '',
        ],
        'image_og' => [
            'type' => OpenGraphImage::class,
            'name' => 'image',
            'content' => '',
        ],
        'type_og' => [
            'type' => OpenGraph::class,
            'name' => 'type',
            'content' => 'website',
        ],
        'url_og' => [
            'type' => OgUrl::class,
            'name' => 'url',
            'content' => '',
        ],
    ],
];
