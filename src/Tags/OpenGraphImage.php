<?php

namespace Codedor\Seo\Tags;

use Codedor\Media\Models\Attachment;

class OpenGraphImage extends OpenGraph
{
    public function getContent(bool $raw = false): string
    {
        $content = parent::getContent();

        if (! parent::getContent()) {
            return '';
        }

        if ($raw) {
            return $content;
        }

        $attachment = \Codedor\Attachments\Models\Attachment::find($this->content);

        if (! $attachment) {
            return '';
        }

         return $attachment->getFormatOrOriginal('og-image');
    }

    public function beforeSave(?string $content): ?string
    {
        return $content;
    }
}
