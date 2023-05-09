<?php

namespace App\Models\Concerns;

trait SeoImageAccessor
{
    /**
     * Set the SEO Image attribute accessor.
     *
     * @throws \RichanFongdasen\I18n\Exceptions\InvalidFallbackLanguageException
     *
     * @return string
     */
    public function getSeoImageLargeAttribute(): string
    {
        $media = $this->getSeoMetaAttribute()->getFirstMediaUrl('seo_image', 'seo_image_large');

        return ($media === '') ? '' : asset($media);
    }

    /**
     * Set the SEO Image attribute accessor.
     *
     * @throws \RichanFongdasen\I18n\Exceptions\InvalidFallbackLanguageException
     *
     * @return string
     */
    public function getSeoImageSmallAttribute(): string
    {
        $media = $this->getSeoMetaAttribute()->getFirstMediaUrl('seo_image', 'seo_image_small');

        return ($media === '') ? '' : asset($media);
    }
}
