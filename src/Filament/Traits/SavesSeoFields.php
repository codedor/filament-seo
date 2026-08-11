<?php

namespace Wotz\Seo\Filament\Traits;

use Wotz\LocaleCollection\Facades\LocaleCollection;
use Wotz\LocaleCollection\Locale;

trait SavesSeoFields
{
    public function afterSave(): void
    {
        $this->saveSeoFields();
    }

    public function afterCreate(): void
    {
        $this->saveSeoFields();
    }

    protected function saveSeoFields(): void
    {
        $state = $this->form->getState();

        if (! $this->hasSeoFields($state)) {
            return;
        }

        $locales = LocaleCollection::map(fn (Locale $locale) => $locale->locale())->all();

        $seoFieldState = [];

        foreach ($state['seoFields'] as $key => $value) {
            if (in_array($key, $locales, true) && is_array($value)) {
                foreach ($value as $seoName => $seoValue) {
                    data_set($seoFieldState, "{$seoName}.{$key}", $seoValue);
                }

                continue;
            }

            $seoFieldState[$key] = $value;
        }

        $this->record->saveSeoFieldState($seoFieldState);

        $this->record->refresh();

        $this->data['seoFields'] = $this->record->fillSeoFieldState();

        LocaleCollection::each(function (Locale $locale) {
            $this->data[$locale->locale()]['seoFields'] = $this->record->fillSeoFieldState($locale->locale());
        });
    }

    protected function hasSeoFields(array $state): bool
    {
        return isset($state['seoFields']);
    }
}
