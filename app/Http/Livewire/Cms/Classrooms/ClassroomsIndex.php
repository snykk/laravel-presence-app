<?php

namespace App\Http\Livewire\Cms\Classrooms;

use App\Models\Classroom;
use Cms\Livewire\DatatableColumn;
use Cms\Livewire\DatatableComponent;
use Illuminate\Database\Eloquent\Builder;

class ClassroomsIndex extends DatatableComponent
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
            DatatableColumn::make('building_id'),
            DatatableColumn::make('room_number'),
            DatatableColumn::make('capacity'),
            DatatableColumn::make('floor'),
            DatatableColumn::make('status'),
            DatatableColumn::make('created_at'),
            DatatableColumn::make('updated_at'),

            DatatableColumn::make('building.id'),
            DatatableColumn::make('building.name'),
            DatatableColumn::make('building.address'),
            DatatableColumn::make('building.created_at'),
            DatatableColumn::make('building.updated_at'),
        ]);
    }

    /**
     * Defines the base route name for current datatable component.
     *
     * @return string
     */
    public function getBaseRouteName(): string
    {
        return 'cms.classrooms.';
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
                'title' => 'Classrooms',
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
        return (new Classroom())
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
        return view('livewire.cms.classrooms.classrooms_index')
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
            'room_number',
            'status',
            'building.name',
            'building.address',
        ];
    }
}
