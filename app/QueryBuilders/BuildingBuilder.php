<?php

namespace App\QueryBuilders;

use App\Http\Requests\BuildingGetRequest;
use App\Models\Building;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

final class BuildingBuilder extends Builder
{
// Used traits declaration
    /**
     * Current HTTP Request object.
     *
     * @var BuildingGetRequest
     */
    protected $request;

    /**
     * BuildingBuilder constructor.
     *
     * @param BuildingGetRequest $request
     */
    public function __construct(BuildingGetRequest $request)
    {
        $this->request = $request;
        $this->builder = QueryBuilder::for(Building::class, $request);
    }

    /**
     * Get a list of allowed columns that can be selected.
     *
     * @return string[]
     */
    protected function getAllowedFields(): array
    {
        return [
            'buildings.id',
            'buildings.name',
            'buildings.address',
            'buildings.created_at',
            'buildings.updated_at',
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
            'name',
            'address',
            AllowedFilter::exact('created_at'),
            AllowedFilter::exact('updated_at'),
            AllowedFilter::exact('buildings.id'),
            'buildings.name',
            'buildings.address',
            AllowedFilter::exact('buildings.created_at'),
            AllowedFilter::exact('buildings.updated_at'),
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
            'classrooms',
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
            'address',
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
            'name',
            'address',
            'created_at',
            'updated_at',
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
