<?php

namespace Codedor\Seo\Models;

use Illuminate\Database\Eloquent\Model;

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
