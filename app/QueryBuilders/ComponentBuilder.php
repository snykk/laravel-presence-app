<?php

namespace App\QueryBuilders;

use App\Http\Requests\ComponentGetRequest;
use App\Models\Component;
use Carbon\Carbon;
use Cms\QueryBuilders\Concerns\SupportTranslations;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

final class ComponentBuilder extends Builder
{
    use SupportTranslations;

    /**
     * Current HTTP Request object.
     *
     * @var ComponentGetRequest
     */
    protected $request;

    /**
     * ComponentBuilder constructor.
     *
     * @param ComponentGetRequest $request
     */
    public function __construct(ComponentGetRequest $request)
    {
        $this->request = $request;
        $this->builder = QueryBuilder::for(Component::class, $request);
    }

    /**
     * Get a list of allowed columns that can be selected.
     *
     * @return string[]
     */
    protected function getAllowedFields(): array
    {
        return [
            'components.id',
            'components.published_at',
            'components.name',
            'components.slug',
            'components.order',
            'components.type',
            'components.created_at',
            'components.updated_at',
            'components.deleted_at',
        ];
    }

    /**
     * Get a list of allowed columns that can be used in any filter operations.
     *
     * @return array
     */
    protected function getAllowedFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('published_at'),
            'name',
            'slug',
            AllowedFilter::exact('created_at'),
            AllowedFilter::exact('type'),
            AllowedFilter::exact('order'),
            AllowedFilter::exact('updated_at'),
            AllowedFilter::exact('deleted_at'),
            AllowedFilter::exact('components.id'),
            AllowedFilter::exact('components.published_at'),
            'components.name',
            'components.slug',
            AllowedFilter::exact('components.created_at'),
            AllowedFilter::exact('components.type'),
            AllowedFilter::exact('components.order'),
            AllowedFilter::exact('components.updated_at'),
            AllowedFilter::exact('components.deleted_at'),
        ];
    }

    /**
     * Get a list of allowed relationships that can be used in any include operations.
     *
     * @return string[]
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'translations',
            'ctas',
        ];
    }

    /**
     * Get a list of allowed searchable columns which can be used in any search operations.
     *
     * @return string[]
     */
    protected function getAllowedSearch(): array
    {
        return [
            'name',
            'slug',
            'title',
            'description',
            'content',
        ];
    }

    /**
     * Get a list of allowed columns that can be used in any sort operations.
     *
     * @return string[]
     */
    protected function getAllowedSorts(): array
    {
        return [
            'id',
            'published_at',
            'name',
            'slug',
            'order',
            'type',
            'created_at',
            'updated_at',
            'deleted_at',
            'title',
            'description',
            'content',
        ];
    }

    /**
     * Get the default sort column that will be used in any sort operation.
     *
     * @return string
     */
    protected function getDefaultSort(): string
    {
        return 'order';
    }

    /**
     * Get default query builder.
     *
     * @return QueryBuilder
     */
    public function query(): QueryBuilder
    {
        // @phpstan-ignore-next-line
        return parent::query()
            ->allowedAppends([
                'medium_images',
                'large_images',
                'ctas',
            ])
            ->where('published_at', '<=', Carbon::now());
    }
}
