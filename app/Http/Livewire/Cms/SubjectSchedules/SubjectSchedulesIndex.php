<?php

namespace App\Http\Livewire\Cms\SubjectSchedules;

use App\Models\SubjectSchedule;
use Cms\Livewire\DatatableColumn;
use Cms\Livewire\DatatableComponent;
use Illuminate\Database\Eloquent\Builder;

class SubjectSchedulesIndex extends DatatableComponent
{
    /**
     * Specify the datatable's columns and their behaviors.
     *
     * @return array
     */
    public function columns(): array
    {
        return $this->applyColumnVisibility([
            DatatableColumn::make('id'),
            DatatableColumn::make('subject_id'),
            DatatableColumn::make('schedule_id'),
            DatatableColumn::make('created_at'),
            DatatableColumn::make('updated_at'),

            DatatableColumn::make('subject.id'),
            DatatableColumn::make('subject.department_id'),
            DatatableColumn::make('subject.code'),
            DatatableColumn::make('subject.score_credit'),
            DatatableColumn::make('subject.created_at'),
            DatatableColumn::make('subject.updated_at'),

            DatatableColumn::make('schedule.id'),
            DatatableColumn::make('schedule.seq'),
            DatatableColumn::make('schedule.start_time'),
            DatatableColumn::make('schedule.end_time'),
            DatatableColumn::make('schedule.created_at'),
            DatatableColumn::make('schedule.updated_at'),
        ]);
    }

    /**
     * Defines the base route name for current datatable component.
     *
     * @return string
     */
    public function getBaseRouteName(): string
    {
        return 'cms.subject_schedules.';
    }

    /**
     * Provide the breadcrumb items for the current livewire component.
     *
     * @return array[]
     */
    public function getBreadcrumbItemsProperty(): array
    {
        return [
            [
                'title' => 'Subject Schedules',
                'url' => route($this->getBaseRouteName() . 'index'),
            ]
        ];
    }

    /**
     * Get a new query builder instance for the current datatable component.
     * You may include the model's relationships if it's necessary.
     *
     * @return Builder
     */
    protected function newQuery(): Builder
    {
        return (new SubjectSchedule())
            ->newQuery()
// query relations
;
    }

    /**
     * Render the LiveWire component.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|mixed
     */
    public function render()
    {
        return view('livewire.cms.subject_schedules.subject_schedules_index')
            ->extends('cms::_layouts.app')
            ->section('content');
    }

    /**
     * Specify the searchable column names in the current datatable component.
     *
     * @return array
     */
    protected function searchableColumns(): array
    {
        return [
            'subject.code',
        ];
    }
}
