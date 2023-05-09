<?php

namespace App\Http\Livewire\Cms\Departments;

use App\Models\Department;
use Cms\Livewire\DatatableColumn;
use Cms\Livewire\DatatableComponent;
use Illuminate\Database\Eloquent\Builder;

class DepartmentsIndex extends DatatableComponent
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
            DatatableColumn::make('code'),
            DatatableColumn::make('name'),
            DatatableColumn::make('description'),

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
        return 'cms.departments.';
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
                'title' => 'Departments',
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
        return (new Department())
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
        return view('livewire.cms.departments.departments_index')
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
            'name',
            'description',
        ];
    }
}
