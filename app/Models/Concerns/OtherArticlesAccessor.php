<?php

namespace App\Models\Concerns;

trait OtherArticlesAccessor
{
    /**
     * Get otherArticles attribute (accessor).
     *
     * @return mixed
     */
    public function getOtherArticlesAttribute()
    {
        return self::where('articles.id', '<>', $this->id)->where('published_at', '!=', null)->latest('published_at')->limit(4)->inRandomOrder()->joinTranslation()->get();
    }

    /**
     * Get otherArticles attribute (accessor).
     *
     * @return mixed
     */
    public function getOtherArticlesWithExtraSmallImageAttribute()
    {
        return $this->getOtherArticlesAttribute()->append('extra_small_image');
    }

    /**
     * Get otherArticles attribute (accessor).
     *
     * @return mixed
     */
    public function getOtherArticlesWithSmallImageAttribute()
    {
        return $this->getOtherArticlesAttribute()->append('small_image');
    }

    /**
     * Get otherArticles attribute (accessor).
     *
     * @return mixed
     */
    public function getOtherArticlesWithMediumImageAttribute()
    {
        return $this->getOtherArticlesAttribute()->append('medium_image');
    }

    /**
     * Get otherArticles attribute (accessor).
     *
     * @return mixed
     */
    public function getOtherArticlesWithLargeImageAttribute()
    {
        return $this->getOtherArticlesAttribute()->append('large_image');
    }

    /**
     * Get otherArticles attribute (accessor).
     *
     * @return mixed
     */
    public function getOtherArticlesWithExtraSmallResponsiveImagesAttribute()
    {
        return $this->getOtherArticlesAttribute()->append('extra_small_responsive_images');
    }

    /**
     * Get otherArticles attribute (accessor).
     *
     * @return mixed
     */
    public function getOtherArticlesWithSmallResponsiveImagesAttribute()
    {
        return $this->getOtherArticlesAttribute()->append('small_responsive_images');
    }

    /**
     * Get otherArticles attribute (accessor).
     *
     * @return mixed
     */
    public function getOtherArticlesWithMediumResponsiveImagesAttribute()
    {
        return $this->getOtherArticlesAttribute()->append('medium_responsive_images');
    }

    /**
     * Get otherArticles attribute (accessor).
     *
     * @return mixed
     */
    public function getOtherArticlesWithLargeResponsiveImagesAttribute()
    {
        return $this->getOtherArticlesAttribute()->append('large_responsive_images');
    }
}
