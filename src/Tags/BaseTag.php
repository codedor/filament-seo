<?php

namespace Codedor\Seo\Tags;

use Illuminate\Support\Str;

class BaseTag implements Tag
{
    protected $attribute = 'name';

    protected $prefix = '';

    protected $identifierPrefix = '';

    protected $key;

    protected $content;

    protected $settings;

    public function __construct(string $key, ?string $content, array $settings = [])
    {
        $this->key = $key;
        $this->content = $content;
        $this->settings = $settings;
    }

    public function beforeSave(?string $content): ?string
    {
        $rules = $this->rules();
        $maxLength = 255;

        // Limit seo content length based on max length rules from config
        foreach ($rules as $rule) {
            if (strpos($rule, 'max:') !== false) {
                $maxLength = (int) str_replace('max:', '', $rule);
            }
        }

        return Str::limit(strip_tags($content), $maxLength, '');
    }

    public function identifier(): string
    {
        return $this->identifierPrefix . $this->key();
    }

    public function key(): string
    {
        return $this->key ?? '';
    }

    public function prefixedKey(): string
    {
        return $this->prefix . $this->key();
    }

    public function content(bool $raw = false): string
    {
        return $this->content ?? '';
    }

    public function settings(?string $key = null)
    {
        if ($key) {
            return $this->settings[$key] ?? null;
        }

        return $this->settings;
    }

    public function render(): string
    {
        $content = str_replace('"', '\'', $this->content() ?? '');

        return "<meta {$this->attribute}=\"{$this->prefixedKey()}\" content=\"{$content}\">";
    }

    public function rules(): array
    {
        $rules = [];

        if (! $this->settings('default') && config('seo.rules.default_empty_required')) {
            $rules[] = 'required';
        }

        $configRules = config('seo.rules.fields.' . $this->identifier(), []);

        return array_merge($rules, $configRules);
    }

    public function __debugInfo()
    {
        return [
            'identifier' => $this->identifier(),
            'key' => $this->key(),
            'content' => $this->content(),
            'settings' => $this->settings(),
            'html' => $this->render(),
        ];
    }
}
