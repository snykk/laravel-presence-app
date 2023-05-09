<?php

namespace App\Models\Concerns;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

trait Sluggable
{
    use HasSlug;

    // protected $sluggable = [
    //     'build_from' => 'name',
    //     'save_to' => 'slug',
    // ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        $options = $this->sluggable;
        $slugField = $options['save_to'] ?? 'slug';

        return SlugOptions::create()
            ->generateSlugsFrom($options['build_from'])
            ->saveSlugsTo($slugField);
    }
}
