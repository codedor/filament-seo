<?php

namespace Codedor\Seo\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $route
 * @property string $og_type
 * @property string $og_image
 * @property string $og_title
 * @property string $og_description
 * @property string $meta_title
 * @property string $meta_description
 */
class SeoRoute extends Model
{
    protected $fillable = [
        'route',
        'og_type',
        'og_image',
        'og_title',
        'og_description',
        'meta_title',
        'meta_description',
    ];
}
