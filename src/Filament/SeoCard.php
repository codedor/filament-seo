<?php

namespace Codedor\Seo\Filament;

use Codedor\MediaLibrary\Components\Fields\AttachmentInput;
use Codedor\Seo\Formats\OgImage;
use Codedor\Seo\Tags\BaseTag;
use Codedor\Seo\Tags\OpenGraphImage;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Model;

class SeoCard
{
    public static function make(string $model, string $locale = null): Card
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

        return Card::make()->columns(1)->label('Seo')
            ->schema([
                Group::make([
                    Placeholder::make('Seo')
                        ->hiddenLabel()
                        ->content('Seo')
                        ->extraAttributes(['class' => 'text-2xl font-bold']),
                    ...$fields->toArray(),
                ])
                    ->afterStateHydrated(function (Group $component, ?Model $record) use ($locale): void {
                        $component->getChildComponentContainer()->fill($record?->fillSeoFieldState($locale));
                    })
                    ->statePath('seoFields'),
            ]);
    }
}
