<?php

namespace App\Models\Concerns;

use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait ConvertImage
{
    use HandleImage;
    use HandleUploadedMedia;
    use InteractsWithMedia;

    protected function queueImageConversion(): bool
    {
        return false;
    }

    protected function responsiveImages(): bool
    {
        return true;
    }

    public function registerMediaCollections(): void
    {
        $imageCollections = $this->getAllImageCollections();
        foreach ($imageCollections as $imageCollection) {
            $this->addMediaCollection($imageCollection)
                ->singleFile()
                ->acceptsMimeTypes([
                    'image/jpg',
                    'image/jpeg',
                    'image/png',
                ]);
        }
    }

    protected function getSizes(): array
    {
        return [
            'extra_small' => [
                'w' => 150,
                'h' => 100,
            ],
            'small' => [
                'w' => 253,
                'h' => 142,
            ],
            'medium' => [
                'w' => 541,
                'h' => 336,
            ],
            'large' => [
                'w' => 896,
                'h' => 505,
            ],
        ];
    }

    /**
     * Get image collection.
     *
     * @return array
     */
    abstract protected function getAllImageCollections(): array;

    /**
     * Register media conversions.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function registerMediaConversions(Media $media = null): void
    {
        foreach ($this->getSizes() as $name => $size) {
            $queue = ($this->queueImageConversion()) ? 'queued' : 'nonQueued';

            /** @phpstan-ignore-next-line */
            $mediaConversion = $this->addMediaConversion($name)
                ->keepOriginalImageFormat()
                ->quality(config('media-library.quality', 95))
                ->optimize();

            if ($this->responsiveImages()) {
                /** @phpstan-ignore-next-line */
                $mediaConversion = $mediaConversion->withResponsiveImages();
            }

            /** @phpstan-ignore-next-line */
            $mediaConversion
                ->width($size['w'])
                ->height($size['h'])
                ->sharpen(10)
                ->performOnCollections(...$this->getAllImageCollections())
                ->$queue();
        }
    }

    /**
     * Store media.
     *
     * @param mixed       $image
     * @param string      $collectionName
     * @param string|null $imageUrl
     */
    public function storeMedia(mixed $image, string $collectionName, string|null $imageUrl): void
    {
        if (isset($imageUrl)) {
            $this->clearMediaCollection($collectionName);
        }

        $this
            ->addFromMediaLibraryRequest($image)
            ->usingName(sha1((string) time()))
            ->usingFileName(sha1((string) time()))
            ->toMediaCollection($collectionName);
    }
}
