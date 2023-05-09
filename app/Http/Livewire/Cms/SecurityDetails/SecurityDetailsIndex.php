<?php

namespace App\Http\Livewire\Cms\SecurityDetails;

use App\Http\Livewire\Cms\Extensions\PublishedDateColumn;
use App\Models\SecurityDetail;
use Cms\Livewire\DatatableColumn;
use Cms\Livewire\DatatableComponent;
use Illuminate\Database\Eloquent\Builder;

class SecurityDetailsIndex extends DatatableComponent
{
    use PublishedDateColumn;

    /**
     * Specify the datatable's columns and their behaviors.
     *
     * @return array
     */
    public function columns(): array
    {
        return $this->applyColumnVisibility([
            DatatableColumn::make('id'),
            DatatableColumn::make('order'),
            DatatableColumn::make('title'),
            DatatableColumn::make('description'),
            $this->publishedDateColumnFormat(),
        ]);
    }

    /**
     * Defines the base route name for current datatable component.
     *
     * @return string
     */
    public function getBaseRouteName(): string
    {
        return 'cms.security_details.';
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
                'title' => 'Security Details',
                'url'   => route($this->getBaseRouteName().'index'),
            ],
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
        return (new SecurityDetail())
            ->newQuery()
            ->joinTranslation();
    }

    /**
     * Render the LiveWire component.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|mixed
     */
    public function render()
    {
        return view('livewire.cms.security_details.security_details_index')
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
            'title',
            'description',
        ];
    }
}
