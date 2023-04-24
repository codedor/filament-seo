<?php

namespace Codedor\Seo\Tags;

use Codedor\Media\Models\Attachment;

class OpenGraphImage extends OpenGraph
{
    public function content(bool $raw = false) : string
    {
        if (! $this->content) {
            return '';
        }

        if ($raw) {
            return $this->content;
        }

        return $this->content;
        // $attachment = Attachment::find($this->content);

        // if (! $attachment) {
        //     return '';
        // }

        // return $attachment->getFormatOrOriginal('og_image');
    }

    public function beforeSave(?string $content) : ?string
    {
        return $content;
    }
}
