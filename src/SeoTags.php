<?php
namespace Codedor\Seo;

class SeoTags
{
    protected static $prefixes = [
        'og',
        'meta',
    ];

    /**
     * Convert database fields to meta tags
     * Expects a key => value array
     */
    public static function fromDatabaseFields(array $data) : array
    {
        $tags = [];

        foreach ($data as $field => $value) {
            foreach (self::$prefixes as $prefix) {
                if (strpos($field, $prefix . '_') === 0 && $value) {
                    $tag = self::addField($field, $value, $prefix);

                    if ($tag) {
                        $tags[] = $tag;
                    }
                }
            }
        }

        return $tags;
    }

    public static function addField(string $field, string $value, string $prefix) : array
    {
        $cleanField = str_replace($prefix . '_', '', $field);

        if ($prefix === 'og') {
            return [
                'property' => $prefix . ':' . $cleanField,
                'content' => $value,
            ];
        }

        if ($prefix) {
            return [
                'name' => $cleanField,
                'content' => $value,
            ];
        }

        return [];
    }

    public static function html(array $seoTags) : string
    {
        $output = '';

        foreach ($seoTags as $seoTag) {
            $output .= self::createTag($seoTag);
        }

        return $output;
    }

    /**
     * Create meta tag from attributes
     */
    private static function createTag(array $values)
    {
        $attributes = array_map(function ($key) use ($values) {
            $value = self::fix($values[$key]);

            return "{$key}=\"{$value}\"";
        }, array_keys($values));
        $attributes = implode(' ', $attributes);

        return "<meta {$attributes}>\n    ";
    }

    private static function fix(string $text) : string
    {
        $text = preg_replace('/<[^>]+>/', ' ', $text);
        $text = preg_replace('/[\r\n\s]+/', ' ', $text);

        return trim(str_replace('"', '&quot;', $text));
    }
}
