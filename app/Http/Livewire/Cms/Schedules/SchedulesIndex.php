<?php

namespace App\Http\Livewire\Cms\Schedules;

use App\Models\Schedule;
use Cms\Livewire\DatatableColumn;
use Cms\Livewire\DatatableComponent;
use Illuminate\Database\Eloquent\Builder;

class SchedulesIndex extends DatatableComponent
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
            DatatableColumn::make('seq'),
            DatatableColumn::make('start_time')->renderWith(function ($model) {
                return $model->start_time->format('H:i:s');
            })->setTitle('Start Time'),
            DatatableColumn::make('end_time')->renderWith(function ($model) {
                return $model->end_time->format('H:i:s');
            })->setTitle('End Time'),
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
        return 'cms.schedules.';
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
                'title' => 'Schedules',
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
        return (new Schedule())
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
        return view('livewire.cms.schedules.schedules_index')
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

        ];
    }
}
