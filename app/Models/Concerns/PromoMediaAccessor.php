<?php

namespace App\Models\Concerns;

use Illuminate\Support\Collection;

trait PromoMediaAccessor
{
    public function getBannerMediumImageAttribute(): string|null
    {
        return $this->banner?->medium_image;
    }

    public function getBannerMediumResponsiveImagesAttribute(): Collection|null
    {
        return $this->banner?->medium_responsive_images;
    }

    public function getBannerLargeImageAttribute(): string|null
    {
        return $this->banner?->large_image;
    }

    public function getBannerLargeResponsiveImagesAttribute(): Collection|null
    {
        return $this->banner?->large_responsive_images;
    }

    public function getBannerWideImageAttribute(): string|null
    {
        return $this->banner?->wide_image;
    }

    public function getBannerWideResponsiveImagesAttribute(): Collection|null
    {
        return $this->banner?->wide_responsive_images;
    }

    public function getBrandExtraSmallImageAttribute(): string|null
    {
        return $this->brand?->extra_small_image;
    }

    public function getBrandExtraSmallResponsiveImagesAttribute(): Collection|null
    {
        return $this->brand?->extra_small_responsive_images;
    }

    public function getBrandSmallImageAttribute(): string|null
    {
        return $this->brand?->small_image;
    }

    public function getBrandSmallResponsiveImagesAttribute(): Collection|null
    {
        return $this->brand?->small_responsive_images;
    }

    public function getBrandMediumImageAttribute(): string|null
    {
        return $this->brand?->medium_image;
    }

    public function getBrandMediumResponsiveImagesAttribute(): Collection|null
    {
        return $this->brand?->medium_responsive_images;
    }

    public function getBrandLargeImageAttribute(): string|null
    {
        return $this->brand?->large_image;
    }

    public function getBrandLargeResponsiveImagesAttribute(): Collection|null
    {
        return $this->brand?->large_responsive_images;
    }

    public function getPromoThumbnailSmallImageAttribute(): string|null
    {
        return $this->small_image;
    }

    public function getPromoThumbnailMediumImageAttribute(): string|null
    {
        return $this->medium_image;
    }

    public function getPromoThumbnailLargeImageAttribute(): string|null
    {
        return $this->large_image;
    }
}
