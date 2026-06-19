<?php

namespace App\Concerns;

trait HasLocalizedFields
{
    /**
     * @return list<string>
     */
    public static function localizedLocales(): array
    {
        return ['en', 'ar', 'fr'];
    }

    public function t(string $field, ?string $locale = null): string
    {
        foreach ($this->localizedFallbackOrder($locale) as $loc) {
            $value = $this->localizedValue($field, $loc);

            if ($value !== null) {
                return $value;
            }
        }

        return '';
    }

    public function hasT(string $field, ?string $locale = null): bool
    {
        return $this->t($field, $locale) !== '';
    }

    /**
     * @return list<string>
     */
    protected function localizedFallbackOrder(?string $locale = null): array
    {
        $locale = $locale ?? app()->getLocale();

        return array_values(array_unique([
            $locale,
            'en',
            'ar',
            'fr',
            ...static::localizedLocales(),
        ]));
    }

    protected function localizedValue(string $field, string $locale): ?string
    {
        $value = $this->{"{$field}_{$locale}"} ?? null;

        if (! is_string($value) || $this->isBlankLocalizedValue($value)) {
            return null;
        }

        return $value;
    }

    protected function isBlankLocalizedValue(string $value): bool
    {
        if (trim($value) === '') {
            return true;
        }

        $text = html_entity_decode(strip_tags($value), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = str_replace(["\xc2\xa0", '&nbsp;', '&#160;'], ' ', $text);
        $text = preg_replace('/\s+/u', '', $text) ?? '';

        return $text === '';
    }
}
