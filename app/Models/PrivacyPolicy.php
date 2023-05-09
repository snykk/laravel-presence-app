<?php

namespace App\Models;

use App\Models\Concerns\ConvertImage;
use App\Models\Concerns\OldDateSerializer;
use App\Models\Concerns\RouteSluggable;
use App\Models\Concerns\SeoImageAccessor;
use Cms\Contracts\SeoAttachedModel;
use Cms\Models\Concerns\HasSeoMeta;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use RichanFongdasen\I18n\Contracts\TranslatableModel;
use RichanFongdasen\I18n\Eloquent\Extensions\Translatable;
use RichanFongdasen\Varnishable\Model\Concerns\Varnishable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class PrivacyPolicy extends Model implements TranslatableModel, SeoAttachedModel, HasMedia
{
    use HasFactory;
    use Translatable;
    use HasSlug;
    use HasSeoMeta;
    use SeoImageAccessor;
    use RouteSluggable;
    use OldDateSerializer;
    use ConvertImage;
    use Varnishable;

    const IMAGE_COLLECTION = 'image';

    /**
     * Specify route key name column.
     *
     * @var string
     */
    protected $routeKey = 'slug';

    /**
     * Get field that will be made into slug.
     *
     * @return string
     */
    protected function getSlugSource(): string
    {
        return 'title';
    }

    /**
     * Get the options for generating the slug.
     *
     * @throws \Exception
     *
     * @return SlugOptions
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom($this->getSlugSource())
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @var string[]
     */
    protected $dates = [
        'published_at',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden.
     *
     * @var string[]
     */
    protected $hidden = [
        'translations',
        'media',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'slug',
        'order',
        'published_at',
        'is_private',
    ];

    /**
     * List all of the translatable attributes.
     *
     * @var string[]
     */
    protected array $translateFields = [
        'title',
        'description',
    ];

    /**
     * The database table which stores all of the translation values.
     *
     * @var string
     */
    protected string $translationTable = 'privacy_policies_translations';

    protected $appends = [
        'small_image',
        'medium_image',
        'large_image',
    ];

    /**
     * Get the translated `title` attribute.
     *
     * @throws \ErrorException
     *
     * @return string
     */
    public function getTitleAttribute(): string
    {
        return (string) $this->getAttribute('title');
    }

    /**
     * Get the translated `description` attribute.
     *
     * @throws \ErrorException
     *
     * @return string
     */
    public function getDescriptionAttribute(): string
    {
        return (string) $this->getAttribute('description');
    }

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param DateTimeInterface $date
     *
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d');
    }

    /**
     * Model relationship definition.
     * PrivacyDetail belongs to PrivacyPolicy.
     *
     * @return HasMany
     */
    public function privacyDetails(): HasMany
    {
        return $this->hasMany(PrivacyDetail::class);
    }

    /**
     * Get collection name.
     *
     * @return string
     */
    public function getImageMediaCollectionName(): string
    {
        return self::IMAGE_COLLECTION;
    }

    /**
     * Get image collection.
     *
     * @return array
     */
    protected function getAllImageCollections(): array
    {
        return [self::IMAGE_COLLECTION];
    }
}
