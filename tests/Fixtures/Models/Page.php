<?php

namespace Codedor\Seo\Tests\Fixtures\Models;

use Codedor\Seo\Models\Traits\HasSeoFields;
use Codedor\Seo\SeoTags;
use Codedor\Seo\Tags\BaseTag;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasSeoFields;

    protected $fillable = [
        'title',
        'description',
    ];

    public function getSeoTags(): SeoTags
    {
        return SeoTags::make()
            ->add(BaseTag::make($this, 'title', 'title'))
            ->add(BaseTag::make($this, 'description', fn () => $this->body));
    }
}
