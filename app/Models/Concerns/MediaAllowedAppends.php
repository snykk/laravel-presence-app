<?php

namespace App\Models\Concerns;

trait MediaAllowedAppends
{
    /**
     * @param bool $hasExtraSmall
     *
     * @return string[]
     *
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public function getMediaAllowedAppends(bool $hasExtraSmall = true): array
    {
        $allowedAppends = [
            'small_image',
            'medium_image',
            'large_image',
            'small_responsive_images',
            'medium_responsive_images',
            'large_responsive_images',
        ];
        if ($hasExtraSmall) {
            $allowedAppends[] = 'extra_small_image';
            $allowedAppends[] = 'extra_small_responsive_images';
        }

        return $allowedAppends;
    }
}
