<?php

namespace Codedor\Seo\Models;

use Codedor\Seo\Models\Casts\StringOrArrayCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Translatable\HasTranslations;

class SeoField extends Model
{
    use HasTranslations;

    public $fillable = [
        'model_type',
        'model_id',
        'locale',
        'type',
        'name',
        'content',
        'is_translatable',
    ];

    public $translatable = [
        'content',
    ];

    protected $casts = [
        'content' => StringOrArrayCast::class,
    ];

    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    public function isTranslatableAttribute(string $key): bool
    {
        if (! in_array($key, $this->translatable)) {
            return false;
        }

        return $this->is_translatable ?: false;
    }

    public function getCasts(): array
    {
        return array_merge(
            parent::getCasts(),
        );
    }
}
