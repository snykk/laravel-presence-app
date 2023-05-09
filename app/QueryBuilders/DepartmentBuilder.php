<?php

namespace App\QueryBuilders;

use App\Http\Requests\DepartmentGetRequest;
use App\Models\Department;
use Cms\QueryBuilders\Concerns\SupportTranslations;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

final class DepartmentBuilder extends Builder
{
    use SupportTranslations;
    /**
     * Current HTTP Request object.
     *
     * @var DepartmentGetRequest
     */
    protected $request;

    /**
     * DepartmentBuilder constructor.
     *
     * @param DepartmentGetRequest $request
     */
    public function __construct(DepartmentGetRequest $request)
    {
        $this->request = $request;
        $this->builder = QueryBuilder::for(Department::class, $request);
    }

    /**
     * Get a list of allowed columns that can be selected.
     *
     * @return string[]
     */
    protected function getAllowedFields(): array
    {
        return [
            'departments.id',
            'departments.code',
            'departments.created_at',
            'departments.updated_at',
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
            'code',
            AllowedFilter::exact('created_at'),
            AllowedFilter::exact('updated_at'),
            AllowedFilter::exact('departments.id'),
            'departments.code',
            AllowedFilter::exact('departments.created_at'),
            AllowedFilter::exact('departments.updated_at'),
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
            'departmentTranslations',
            'translations',
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
            'code',
            'name',
            'description',
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
            'code',
            'created_at',
            'updated_at',
            'name',
            'description',
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
}
