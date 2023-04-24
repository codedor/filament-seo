<?php

namespace Codedor\Seo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SeoField extends Model
{
    public $fillable = [
        'model_type',
        'model_id',
        'locale',
        'type',
        'name',
        'content',
    ];

    public function model(): MorphTo
    {
        return $this->morphTo();
    }
}
