<?php

namespace Codedor\Seo\Tests\Fixtures\Models;

use Codedor\Seo\Models\Traits\HasSeoFields;
use Codedor\Seo\SeoFieldOptions;
use Codedor\Seo\Tags\BaseTag;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasSeoFields;

    protected $fillable = [
        'title',
        'description',
    ];

    public function getSeoFieldOptions(): SeoFieldOptions
    {
        return SeoFieldOptions::create()
            ->tag([
                'type' => [BaseTag::class],
                'name' => 'title',
                'default' => $this->title,
            ])
            ->tag([
                'type' => [BaseTag::class],
                'name' => 'description',
                'default' => $this->body,
            ]);
    }
}
