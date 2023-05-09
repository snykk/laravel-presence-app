<?php

namespace App\Models\Concerns;

use Illuminate\Support\Collection;

trait HomeBannerMediaAccessor
{
    /**
     * DESKTOP SECTION.
     */
    /**
     * Get the large image attribute (mutator).
     *
     * @return string|null
     */
    public function getDesktopLargeImageAttribute(): ?string
    {
        $image = $this->getFirstMediaUrl($this->getImageMediaCollectionName('desktop'), 'large');

        return ($image === '') ? $image : asset($image);
    }

    /**
     * Get the large detail responsive images.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getDesktopLargeResponsiveImagesAttribute(): Collection
    {
        $image = $this->getFirstMedia($this->getImageMediaCollectionName('desktop'));

        return $this->getResImage($image, 'large');
    }

    /**
     * Get the medium image attribute (mutator).
     *
     * @return string|null
     */
    public function getDesktopMediumImageAttribute(): ?string
    {
        $image = $this->getFirstMediaUrl($this->getImageMediaCollectionName('desktop'), 'medium');

        return ($image === '') ? $image : asset($image);
    }

    /**
     * Get the Medium detail responsive images.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getDesktopMediumResponsiveImagesAttribute(): Collection
    {
        $image = $this->getFirstMedia($this->getImageMediaCollectionName('desktop'));

        return $this->getResImage($image, 'medium');
    }

    /**
     * Get the small image attribute (mutator).
     *
     * @return string|null
     */
    public function getDesktopSmallImageAttribute(): ?string
    {
        $image = $this->getFirstMediaUrl($this->getImageMediaCollectionName('desktop'), 'small');

        return ($image === '') ? $image : asset($image);
    }

    /**
     * Get the small detail responsive images.
     *
     * @return Collection
     */
    public function getDesktopSmallResponsiveImagesAttribute(): Collection
    {
        $image = $this->getFirstMedia($this->getImageMediaCollectionName('desktop'));

        return $this->getResImage($image, 'small');
    }

    /**
     * Get the small image attribute (mutator).
     *
     * @return string|null
     */
    public function getDesktopExtraSmallImageAttribute(): ?string
    {
        $image = $this->getFirstMediaUrl($this->getImageMediaCollectionName('desktop'), 'extra_small');

        return ($image === '') ? $image : asset($image);
    }

    /**
     * Get the large detail responsive images.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getDesktopExtraSmallResponsiveImagesAttribute(): Collection
    {
        $image = $this->getFirstMedia($this->getImageMediaCollectionName('desktop'));

        return $this->getResImage($image, 'extra_small');
    }

    /**
     * MOBILE SECTION.
     */
    /**
     * Get the large image attribute (mutator).
     *
     * @return string|null
     */
    public function getMobileLargeImageAttribute(): ?string
    {
        $image = $this->getFirstMediaUrl($this->getImageMediaCollectionName('mobile'), 'large');

        return ($image === '') ? $image : asset($image);
    }

    /**
     * Get the large detail responsive images.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getMobileLargeResponsiveImagesAttribute(): Collection
    {
        $image = $this->getFirstMedia($this->getImageMediaCollectionName('mobile'));

        return $this->getResImage($image, 'large');
    }

    /**
     * Get the medium image attribute (mutator).
     *
     * @return string|null
     */
    public function getMobileMediumImageAttribute(): ?string
    {
        $image = $this->getFirstMediaUrl($this->getImageMediaCollectionName('mobile'), 'medium');

        return ($image === '') ? $image : asset($image);
    }

    /**
     * Get the Medium detail responsive images.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getMobileMediumResponsiveImagesAttribute(): Collection
    {
        $image = $this->getFirstMedia($this->getImageMediaCollectionName('mobile'));

        return $this->getResImage($image, 'medium');
    }

    /**
     * Get the small image attribute (mutator).
     *
     * @return string|null
     */
    public function getMobileSmallImageAttribute(): ?string
    {
        $image = $this->getFirstMediaUrl($this->getImageMediaCollectionName('mobile'), 'small');

        return ($image === '') ? $image : asset($image);
    }

    /**
     * Get the small detail responsive images.
     *
     * @return Collection
     */
    public function getMobileSmallResponsiveImagesAttribute(): Collection
    {
        $image = $this->getFirstMedia($this->getImageMediaCollectionName('mobile'));

        return $this->getResImage($image, 'small');
    }

    /**
     * Get the small image attribute (mutator).
     *
     * @return string|null
     */
    public function getMobileExtraSmallImageAttribute(): ?string
    {
        $image = $this->getFirstMediaUrl($this->getImageMediaCollectionName('mobile'), 'extra_small');

        return ($image === '') ? $image : asset($image);
    }

    /**
     * Get the large detail responsive images.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getMobileExtraSmallResponsiveImagesAttribute(): Collection
    {
        $image = $this->getFirstMedia($this->getImageMediaCollectionName('mobile'));

        return $this->getResImage($image, 'extra_small');
    }
}
