<?php

namespace Codedor\Seo\Filament\Traits;

trait SavesSeoFields
{
    public function afterSave()
    {
        $this->saveSeoFields();
    }

    protected function saveSeoFields()
    {
        $state = $this->form->getState();

        if (! array_key_exists('seoFields', $state)) {
            return;
        }

        $seoFieldState = [];

        foreach ($state as $key => $value) {
            if ($key === 'seoFields') {
                $seoFieldState += $value;
            }

            if (is_array($value) && array_key_exists('seoFields', $value)) {
                foreach ($value['seoFields'] as $seoName => $seoValue) {
                    data_set($seoFieldState, "{$seoName}.{$key}", $seoValue);
                }
            }
        }

        $this->record->saveSeoFieldState($seoFieldState);

        $this->data['seoFields'] = $this->record->fillSeoFieldState();
    }
}
