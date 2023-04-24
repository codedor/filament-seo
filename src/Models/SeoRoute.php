<?php

namespace Codedor\Seo\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class SeoRoute extends Model
{
    use \Codedor\Translatable\Models\Traits\Translatable;
    use LogsActivity;

    public $translatedAttributes = ['og_title', 'og_description', 'meta_title', 'meta_description', 'online'];

    protected $fillable = [
        'route',
        'og_type',
        'og_image',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontLogIfAttributesChangedOnly(['updated_at']);
    }
}
