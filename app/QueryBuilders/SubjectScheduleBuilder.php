<?php

namespace App\QueryBuilders;

use App\Http\Requests\SubjectScheduleGetRequest;
use App\Models\SubjectSchedule;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

final class SubjectScheduleBuilder extends Builder
{
    /**
     * Current HTTP Request object.
     *
     * @var SubjectScheduleGetRequest
     */
    protected $request;

    /**
     * SubjectScheduleBuilder constructor.
     *
     * @param SubjectScheduleGetRequest $request
     */
    public function __construct(SubjectScheduleGetRequest $request)
    {
        $this->request = $request;
        $this->builder = QueryBuilder::for(SubjectSchedule::class, $request);
    }

    /**
     * Get a list of allowed columns that can be selected.
     *
     * @return string[]
     */
    protected function getAllowedFields(): array
    {
        return [
            'subject_schedule.id',
            'subject_schedule.subject_id',
            'subject_schedule.schedule_id',
            'subject_schedule.created_at',
            'subject_schedule.updated_at',
            'subject.id',
            'subject.department_id',
            'subject.code',
            'subject.score_credit',
            'subject.created_at',
            'subject.updated_at',
            'schedule.id',
            'schedule.seq',
            'schedule.start_time',
            'schedule.end_time',
            'schedule.created_at',
            'schedule.updated_at',
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
            AllowedFilter::exact('subject_id'),
            AllowedFilter::exact('schedule_id'),
            AllowedFilter::exact('created_at'),
            AllowedFilter::exact('updated_at'),
            AllowedFilter::exact('subject_schedule.id'),
            AllowedFilter::exact('subject_schedule.subject_id'),
            AllowedFilter::exact('subject_schedule.schedule_id'),
            AllowedFilter::exact('subject_schedule.created_at'),
            AllowedFilter::exact('subject_schedule.updated_at'),
            AllowedFilter::exact('subject.id'),
            AllowedFilter::exact('subject.department_id'),
            'subject.code',
            AllowedFilter::exact('subject.score_credit'),
            AllowedFilter::exact('subject.created_at'),
            AllowedFilter::exact('subject.updated_at'),
            AllowedFilter::exact('schedule.id'),
            AllowedFilter::exact('schedule.seq'),
            AllowedFilter::exact('schedule.start_time'),
            AllowedFilter::exact('schedule.end_time'),
            AllowedFilter::exact('schedule.created_at'),
            AllowedFilter::exact('schedule.updated_at'),
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
            'subject',
            'schedule',
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
            'subject.code',
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
            'subject_id',
            'schedule_id',
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
