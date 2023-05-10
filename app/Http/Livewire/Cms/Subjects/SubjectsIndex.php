<?php

namespace App\Http\Livewire\Cms\Subjects;

use App\Models\DepartmentTranslation;
use App\Models\Subject;
use Cms\Livewire\DatatableColumn;
use Cms\Livewire\DatatableComponent;
use Illuminate\Database\Eloquent\Builder;

class SubjectsIndex extends DatatableComponent
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
            DatatableColumn::make('department_name'),
            DatatableColumn::make('title'),
            DatatableColumn::make('code'),
            DatatableColumn::make('score_credit'),
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
        return 'cms.subjects.';
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
                'title' => 'Subjects',
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

        return (new Subject())
            ->newQuery()
            ->joinTranslation()
            ->leftJoin('departments', 'subjects.department_id', '=', 'departments.id')
            ->leftJoinSub(DepartmentTranslation::where('locale', $locale)->select(['name', 'department_id']), 'department_translations', function ($join) {
                $join->on('departments.id', 'department_translations.department_id');
            })
            ->with(['translations'])
            ->select(['subjects.*', 'department_translations.name as department_name']);
;
    }

    /**
     * Render the LiveWire component.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|mixed
     */
    public function render()
    {
        return view('livewire.cms.subjects.subjects_index')
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
            'code',
            'department.code',
            'title',
        ];
    }
}
