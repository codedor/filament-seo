<?php

namespace Codedor\Seo\Filament;

use Codedor\MediaLibrary\Filament\AttachmentInput;
use Codedor\Seo\Formats\OgImage;
use Codedor\Seo\Tags\BaseTag;
use Codedor\Seo\Tags\OpenGraphImage;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\Model;

class SeoCard
{
    public static function make(string $model, ?string $locale = null): \Filament\Schemas\Components\Section
    {
        $model = app($model);

        $fields = $model->getSeoTags()
            ->filter(fn (BaseTag $tag) => $tag->isTranslatable() === (bool) $locale)
            ->map(function (BaseTag $tag) {
                if ($tag::class === OpenGraphImage::class) {
                    return AttachmentInput::make($tag->getIdentifier())
                        ->rules($tag->getRules())
                        ->allowedFormats([
                            OgImage::class,
                        ]);
                }

                return Textarea::make($tag->getIdentifier())
                    ->rules($tag->getRules());
            });

        return \Filament\Schemas\Components\Section::make()
            ->columns(1)
            ->label('Seo')
            ->schema([
                \Filament\Schemas\Components\Group::make([
                    TextEntry::make('Seo')
                        ->hiddenLabel()
                        ->state('Seo')
                        ->extraAttributes(['class' => 'text-2xl font-bold']),
                    ...$fields->toArray(),
                ])
                    ->afterStateHydrated(function (\Filament\Schemas\Components\Group $component, ?Model $record) use ($locale): void {
                        $component->getChildSchema()->fill($record?->fillSeoFieldState($locale));
                    })
                    ->statePath('seoFields'),
            ]);
    }
}
