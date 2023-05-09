<?php

namespace App\Vendors\I18n\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class TranslationModel extends Model
{
    use HasSlug;

    /**
     * Enable mass assignment for this
     * model.
     *
     * @var bool
     */
    protected static $unguarded = true;

    /**
     * Disable timestamp in any translation
     * model.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Source column name of generated slug.
     *
     * @var string
     */
    public $generateSlugsFrom = 'title';

    /**
     * Column to save generated slug.
     *
     * @var string
     */
    protected $saveSlugsTo = 'slug';

    /**
     * Return the slug options for this model.
     *
     * @return SlugOptions
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom($this->generateSlugsFrom)
            ->saveSlugsTo($this->saveSlugsTo)
            ->preventOverwrite();
    }

    /**
     * Set generate slug from.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setGenerateSlugsFrom($value)
    {
        $this->generateSlugsFrom = $value;

        return $this;
    }

    /**
     * Set save slug to.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setSaveSlugsTo($value)
    {
        $this->saveSlugsTo = $value;

        return $this;
    }
}
