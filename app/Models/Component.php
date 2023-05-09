<?php

namespace App\Models;

use App\Models\Concerns\HandleImage;
use App\Models\Concerns\HandleUploadedMedia;
use App\Models\Concerns\HasCta;
use App\Models\Concerns\Publishable;
use App\Models\Concerns\RouteSluggable;
use App\Models\Concerns\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use RichanFongdasen\I18n\Contracts\TranslatableModel;
use RichanFongdasen\I18n\Eloquent\Extensions\Translatable;
use RichanFongdasen\Varnishable\Model\Concerns\Varnishable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Component extends Model implements TranslatableModel, HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use HasCta;
    use Translatable;
    use Publishable;
    use HandleImage;
    use HandleUploadedMedia;
    use InteractsWithMedia;
    use RouteSluggable;
    use Sluggable;
    use Varnishable;

    const IMAGE_COLLECTION = 'component-images';

    const TYPES = [
        'default'    => 'Default',
        'gopay-plus' => 'Gopay Plus',
    ];

    /**
     * Specify route key name column.
     *
     * @var string
     */
    protected $routeKey = 'slug';

    /**
     * Define sluggable.
     *
     * @var array
     */
    protected $sluggable = [
        'build_from' => 'name',
        'save_to'    => 'slug',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var string[]
     */
    protected $dates = [
        'published_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be hidden.
     *
     * @var string[]
     */
    protected $hidden = [
        'published_at',
        'created_at',
        'updated_at',
        'deleted_at',
        'translations',
        'media',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'published_at',
        'order',
        'type',
        'name',
        'slug',
    ];

    /**
     * List all of the translatable attributes.
     *
     * @var string[]
     */
    protected array $translateFields = [
        'title',
        'description',
        'content',
    ];

    /**
     * A collection of model relationships for cascading soft deletes automatically.
     *
     * @var string[]
     */
    protected $cascadeDeletes = [
        'translations',
    ];

    /**
     * The database table which stores all of the translation values.
     *
     * @var string
     */
    protected string $translationTable = 'component_translations';

    public function registerMediaCollections(): void
    {
        $locales = ['-en', '-id'];

        foreach ($locales as $locale) {
            $this->addMediaCollection(self::IMAGE_COLLECTION.$locale)
                ->acceptsMimeTypes([
                    'image/jpg',
                    'image/jpeg',
                    'image/png',
                ]);
        }
    }

    /**
     * Register media conversions.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $sizes = [
            'large' => [
                'w' => 1120,
                'h' => 806,
            ],
            'medium' => [
                'w' => 450,
                'h' => 450,
            ],
        ];

        $this->registerMultilingualConversions($sizes);
    }

    /**
     * Image media collection accessor.
     *
     * @return string
     */
    public function getImageMediaCollectionName(): string
    {
        return (config('app.locale') === 'en') ? self::IMAGE_COLLECTION.'-en' : self::IMAGE_COLLECTION.'-id';
    }

    /**
     * Get title attribute (accessor).
     *
     * @return string
     */
    public function getTitleAttribute(): string
    {
        return (string) $this->getAttribute('title');
    }

    /**
     * Get description attribute (accessor).
     *
     * @return string
     */
    public function getDescriptionAttribute(): string
    {
        return (string) $this->getAttribute('description');
    }

    /**
     * Get content attribute (accessor).
     *
     * @return string
     */
    public function getContentAttribute(): string
    {
        return (string) $this->getAttribute('content');
    }

    /**
     * Get anchorMethods attribute (accessor).
     *
     * @return mixed
     */
    public function getCtasAttribute()
    {
        return Cta::where('ctas.ctable_id', $this->id)->where('ctas.ctable_type', self::class)->joinTranslation()->get();
    }

    /**
     * Get the large image attribute (mutator).
     *
     * @return array
     */
    public function getLargeImagesAttribute()
    {
        $images = $this->getMedia($this->getImageMediaCollectionName());
        $urls = [];
        foreach ($images as $key => $value) {
            $urls[$key] = asset($value->getUrl('large'));
        }

        return $urls;
    }

    /**
     * Get the large image attribute (mutator).
     *
     * @return array
     */
    public function getMediumImagesAttribute()
    {
        $images = $this->getMedia($this->getImageMediaCollectionName());
        $urls = [];
        foreach ($images as $key => $value) {
            $urls[$key] = asset($value->getUrl('medium'));
        }

        return $urls;
    }
}
