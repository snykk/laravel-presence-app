<?php

namespace App\Models\Concerns;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

trait Slugable
{
    use HasSlug;

    protected array $slugable = [
        'build_from' => 'title',
        'save_to'    => 'slug',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        $options = $this->slugable;
        $slugField = $options['save_to'] ?? 'slug';

        return SlugOptions::create()
            ->generateSlugsFrom($options['build_from'])
            ->saveSlugsTo($slugField);
    }
}
