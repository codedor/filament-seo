<?php

namespace Codedor\Seo\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class SeoRouteTranslation extends Model
{
    use LogsActivity;

    protected static $recordEvents = ['updated'];

    protected $fillable = ['og_title', 'og_description', 'meta_title', 'meta_description', 'online'];

    public function seoRoute()
    {
        return $this->belongsTo(SeoRoute::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontLogIfAttributesChangedOnly(['updated_at']);
    }
}
