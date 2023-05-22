<?php

namespace App\QueryBuilders;

use App\Http\Requests\ClassroomGetRequest;
use App\Models\Classroom;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

final class ClassroomBuilder extends Builder
{
// Used traits declaration
    /**
     * Current HTTP Request object.
     *
     * @var ClassroomGetRequest
     */
    protected $request;

    /**
     * ClassroomBuilder constructor.
     *
     * @param ClassroomGetRequest $request
     */
    public function __construct(ClassroomGetRequest $request)
    {
        $this->request = $request;
        $this->builder = QueryBuilder::for(Classroom::class, $request);
    }

    /**
     * Get a list of allowed columns that can be selected.
     *
     * @return string[]
     */
    protected function getAllowedFields(): array
    {
        return [
            'classrooms.id',
            'classrooms.building_id',
            'classrooms.room_number',
            'classrooms.capacity',
            'classrooms.floor',
            'classrooms.status',
            'classrooms.created_at',
            'classrooms.updated_at',
            'building.id',
            'building.name',
            'building.address',
            'building.created_at',
            'building.updated_at',
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
            AllowedFilter::exact('building_id'),
            'room_number',
            AllowedFilter::exact('capacity'),
            AllowedFilter::exact('floor'),
            'status',
            AllowedFilter::exact('created_at'),
            AllowedFilter::exact('updated_at'),
            AllowedFilter::exact('classrooms.id'),
            AllowedFilter::exact('classrooms.building_id'),
            'classrooms.room_number',
            AllowedFilter::exact('classrooms.capacity'),
            AllowedFilter::exact('classrooms.floor'),
            'classrooms.status',
            AllowedFilter::exact('classrooms.created_at'),
            AllowedFilter::exact('classrooms.updated_at'),
            AllowedFilter::exact('building.id'),
            'building.name',
            'building.address',
            AllowedFilter::exact('building.created_at'),
            AllowedFilter::exact('building.updated_at'),
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
            'building',
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
            'room_number',
            'status',
            'building.name',
            'building.address',
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
            'building_id',
            'room_number',
            'capacity',
            'floor',
            'status',
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
