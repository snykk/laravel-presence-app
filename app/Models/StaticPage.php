<?php

namespace App\Models;

use App\Models\Concerns\OldDateSerializer;
use App\Models\Concerns\Publishable;
use App\Models\Concerns\RouteSluggable;
use App\Models\Concerns\SeoImageAccessor;
use App\Vendors\I18n\Eloquent\Extensions\TranslatableWithSlug;
use Cms\Contracts\SeoAttachedModel;
use Cms\Models\Concerns\HasSeoMeta;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use RichanFongdasen\I18n\Contracts\TranslatableModel;
use RichanFongdasen\I18n\Eloquent\Extensions\Translatable;
use RichanFongdasen\Varnishable\Model\Concerns\Varnishable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * App\Models\StaticPage.
 *
 * @property int                             $id
 * @property string                          $name
 * @property string                          $slug
 * @property string                          $content
 * @property string|null                     $youtube_video
 * @property string                          $layout
 * @property string                          $published
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Database\Factories\StaticPageFactory            factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticPage findSimilarSlugs(string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticPage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StaticPage newQuery()
 * @method static \Illuminate\Database\Query\Builder|StaticPage    onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|StaticPage query()
 * @method static \Illuminate\Database\Eloquent\Builder|StaticPage whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticPage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticPage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticPage whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticPage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticPage whereLayout($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticPage wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticPage whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticPage whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticPage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticPage whereYoutubeVideo($value)
 * @method static \Illuminate\Database\Query\Builder|StaticPage    withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|StaticPage withUniqueSlugConstraints(\Illuminate\Database\Eloquent\Model $model, string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Query\Builder|StaticPage    withoutTrashed()
 *
 * @mixin \Eloquent
 */
class StaticPage extends Model implements SeoAttachedModel, TranslatableModel
{
    use CascadeSoftDeletes;
    use HasFactory;
    use HasSeoMeta;
    use LogsActivity;
    use SoftDeletes;
//    use TranslatableWithSlug;
    use HasSlug;
    use RouteSluggable;
    use OldDateSerializer;
    use Publishable;
    use Varnishable;
    use SeoImageAccessor;
    use Varnishable;
    use Translatable;

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
        return 'name';
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
     * The attributes that should be hidden.
     *
     * @var string[]
     */
    protected $hidden = [
        'created_at',
        'deleted_at',
        'updated_at',
        'translations',
        'seo_metas',
        'seoMetas',
        'media',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'layout',
        'slug',
        'is_private',
        'published_at',
    ];

    /**
     * List all of the translatable attributes.
     *
     * @var string[]
     */
    protected array $translateFields = [
        'name',
        //        'slug',
        'content',
        'youtube_video',
    ];

    /**
     * Define the activity log options for the model.
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    /**
     * Get name attribute (accessor).
     *
     * @return string
     */
    public function getNameAttribute(): string
    {
        return (string) $this->getAttribute('name');
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
     * Get youtube video attribute (accessor).
     *
     * @return string
     */
    public function getYoutubeVideoAttribute(): string
    {
        return (string) $this->getAttribute('youtube_video');
    }
}
