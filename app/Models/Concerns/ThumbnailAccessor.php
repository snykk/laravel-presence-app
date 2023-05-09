<?php

namespace App\Models\Concerns;

trait ThumbnailAccessor
{
    /**
     * Method to get collection name.
     *
     * @return string
     */
    abstract public function getImageMediaCollectionName(): string;

    /**
     * Get the English thumbnail attribute (mutator).
     *
     * @return string|null
     */
    public function getThumbnailEnAttribute()
    {
        $image = $this->getFirstMediaUrl(self::IMAGE_COLLECTION.'-en', 'small');

        return ($image === '') ? $image : asset($image);
    }

    /**
     * Get the Indonesian thumbnail attribute (mutator).
     *
     * @return string|null
     */
    public function getThumbnailIdAttribute()
    {
        $image = $this->getFirstMediaUrl(self::IMAGE_COLLECTION.'-id', 'small');

        return ($image === '') ? $image : asset($image);
    }

    /**
     * Get the English thumbnail attribute (mutator).
     *
     * @return string|null
     */
    public function getThumbnailExtraSmallEnAttribute()
    {
        $image = $this->getFirstMediaUrl(self::IMAGE_COLLECTION.'-en', 'extra_small');

        return ($image === '') ? $image : asset($image);
    }

    /**
     * Get the Indonesian thumbnail attribute (mutator).
     *
     * @return string|null
     */
    public function getThumbnailExtraSmallIdAttribute()
    {
        $image = $this->getFirstMediaUrl(self::IMAGE_COLLECTION.'-id', 'extra_small');

        return ($image === '') ? $image : asset($image);
    }
}
