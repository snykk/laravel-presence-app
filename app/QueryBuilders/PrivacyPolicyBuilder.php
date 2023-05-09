<?php

namespace App\QueryBuilders;

use App\Http\Requests\PrivacyPolicyGetRequest;
use App\Models\PrivacyPolicy;
use App\QueryBuilders\CustomSorts\SortByPrivacyDetailOrder;
use Cms\QueryBuilders\Concerns\SupportTranslations;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

final class PrivacyPolicyBuilder extends Builder
{
    use SupportTranslations;

    /**
     * Current HTTP Request object.
     *
     * @var PrivacyPolicyGetRequest
     */
    protected $request;

    /**
     * PrivacyPolicyBuilder constructor.
     *
     * @param PrivacyPolicyGetRequest $request
     */
    public function __construct(PrivacyPolicyGetRequest $request)
    {
        $this->request = $request;
        $this->builder = QueryBuilder::for(PrivacyPolicy::class, $request);
    }

    /**
     * Get a list of allowed columns that can be selected.
     *
     * @return string[]
     */
    protected function getAllowedFields(): array
    {
        return [
            'privacy_policies.id',
            'privacy_policies.slug',
            'privacy_policies.order',
            'privacy_policies.published_at',
            'privacy_policies.created_at',
            'privacy_policies.updated_at',
            'privacy_policies.title',
            'privacy_policies.description',
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
            'slug',
            AllowedFilter::exact('order'),
            AllowedFilter::exact('published'),
            AllowedFilter::exact('published_at'),
            AllowedFilter::exact('created_at'),
            AllowedFilter::exact('updated_at'),
            AllowedFilter::exact('privacy_policies.id'),
            'privacy_policies.slug',
            AllowedFilter::exact('privacy_policies.order'),
            AllowedFilter::exact('privacy_policies.published_at'),
            AllowedFilter::exact('privacy_policies.created_at'),
            AllowedFilter::exact('privacy_policies.updated_at'),
            AllowedFilter::exact('privacy_policies.is_private'),
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
            'privacy_details',
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
            'slug',
        ];
    }

    /**
     * Get a list of allowed columns that can be used in any sort operations.
     *
     * @return array
     */
    protected function getAllowedSorts(): array
    {
        return [
            'id',
            'slug',
            'order',
            'published_at',
            'created_at',
            'updated_at',
            AllowedSort::custom('privacyDetail.order', new SortByPrivacyDetailOrder()),
        ];
    }

    /**
     * Get the default sort column that will be used in any sort operation.
     *
     * @return string
     */
    protected function getDefaultSort(): string
    {
        return 'id';
    }

    /**
     * Get default query builder.
     *
     * @return QueryBuilder
     */
    public function query(): QueryBuilder
    {
        return parent::query()
            ->allowedAppends([
                'extra_small_image',
                'small_image',
                'medium_image',
                'large_image',
                'extra_small_responsive_images',
                'small_responsive_images',
                'medium_responsive_images',
                'large_responsive_images',
                'seo_meta',
                'seo_image_large',
                'seo_image_small',
            ]);
    }
}
