<?php

namespace App\QueryBuilders;

use App\Http\Requests\ScheduleGetRequest;
use App\Models\Schedule;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

final class ScheduleBuilder extends Builder
{
// Used traits declaration
    /**
     * Current HTTP Request object.
     *
     * @var ScheduleGetRequest
     */
    protected $request;

    /**
     * ScheduleBuilder constructor.
     *
     * @param ScheduleGetRequest $request
     */
    public function __construct(ScheduleGetRequest $request)
    {
        $this->request = $request;
        $this->builder = QueryBuilder::for(Schedule::class, $request);
    }

    /**
     * Get a list of allowed columns that can be selected.
     *
     * @return string[]
     */
    protected function getAllowedFields(): array
    {
        return [
            'schedules.id',
            'schedules.seq',
            'schedules.start_time',
            'schedules.end_time',
            'schedules.created_at',
            'schedules.updated_at',
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
            AllowedFilter::exact('seq'),
            AllowedFilter::exact('start_time'),
            AllowedFilter::exact('end_time'),
            AllowedFilter::exact('created_at'),
            AllowedFilter::exact('updated_at'),
            AllowedFilter::exact('schedules.id'),
            AllowedFilter::exact('schedules.seq'),
            AllowedFilter::exact('schedules.start_time'),
            AllowedFilter::exact('schedules.end_time'),
            AllowedFilter::exact('schedules.created_at'),
            AllowedFilter::exact('schedules.updated_at'),
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
            'subjectSchedules',
            'subjects',
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
            'seq',
            'start_time',
            'end_time',
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
