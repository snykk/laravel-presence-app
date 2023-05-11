<?php

namespace App\Http\Livewire\Cms\SubjectSchedules;

use App\Models\SubjectSchedule;
use App\Models\SubjectTranslation;
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
            DatatableColumn::make('subject_title')->setTitle('Subject'),
            DatatableColumn::make('class_index'),
            DatatableColumn::make('seq'),
            DatatableColumn::make('start_time'),
            DatatableColumn::make('end_time'),
            DatatableColumn::make('created_at'),
            DatatableColumn::make('updated_at'),
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
        $locale = request()->query('locale') ?? 'en';

        return (new SubjectSchedule())
            ->newQuery()
            ->leftJoin('subjects', 'subject_schedules.subject_id', '=', 'subjects.id')
            ->leftJoinSub(SubjectTranslation::where('locale', $locale)->select(['title', 'subject_id']), 'subject_translations', function ($join) {
                $join->on('subjects.id', 'subject_translations.subject_id');
            })
            ->leftJoin('schedules', 'subject_schedules.schedule_id', '=', 'schedules.id')
            ->select(['subject_schedules.*', 'subject_translations.title as subject_title', 'schedules.start_time','schedules.end_time','schedules.seq']);
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
