<?php

namespace App\QueryBuilders;

use App\Http\Requests\SubjectGetRequest;
use App\Models\Subject;
use Cms\QueryBuilders\Concerns\SupportTranslations;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

final class SubjectBuilder extends Builder
{
    use SupportTranslations;
    /**
     * Current HTTP Request object.
     *
     * @var SubjectGetRequest
     */
    protected $request;

    /**
     * SubjectBuilder constructor.
     *
     * @param SubjectGetRequest $request
     */
    public function __construct(SubjectGetRequest $request)
    {
        $this->request = $request;
        $this->builder = QueryBuilder::for(Subject::class, $request);
    }

    /**
     * Get a list of allowed columns that can be selected.
     *
     * @return string[]
     */
    protected function getAllowedFields(): array
    {
        return [
            'subjects.id',
            'subjects.department_id',
            'subjects.code',
            'subjects.score_credit',
            'subjects.created_at',
            'subjects.updated_at',
            'department.id',
            'department.code',
            'department.created_at',
            'department.updated_at',
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
            AllowedFilter::exact('department_id'),
            'code',
            AllowedFilter::exact('score_credit'),
            AllowedFilter::exact('created_at'),
            AllowedFilter::exact('updated_at'),
            AllowedFilter::exact('subjects.id'),
            AllowedFilter::exact('subjects.department_id'),
            'subjects.code',
            AllowedFilter::exact('subjects.score_credit'),
            AllowedFilter::exact('subjects.created_at'),
            AllowedFilter::exact('subjects.updated_at'),
            AllowedFilter::exact('department.id'),
            'department.code',
            AllowedFilter::exact('department.created_at'),
            AllowedFilter::exact('department.updated_at'),
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
            'department',
            'subjectSchedules',
            'subjectTranslations',
            'schedules',
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
            'department.code',
            'title',
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
            'department_id',
            'code',
            'score_credit',
            'created_at',
            'updated_at',
            'title',
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
