<?php

namespace App\Http\Livewire\Cms\PrivacyDetails;

use App\Models\PrivacyDetail;
use Cms\Livewire\DatatableColumn;
use Cms\Livewire\DatatableComponent;
use Illuminate\Database\Eloquent\Builder;

class PrivacyDetailsIndex extends DatatableComponent
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
            DatatableColumn::make('privacyPolicy.slug')->notSortable()->setTitle('Privacy Policy\'s Slug'),
            DatatableColumn::make('title'),
            DatatableColumn::make('order'),
            DatatableColumn::make('published_at'),
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
        return 'cms.privacy_details.';
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
                'title' => 'Privacy Details',
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
        return (new PrivacyDetail())
            ->newQuery()
            ->joinTranslation()
            ->with(['privacyPolicy']);
    }

    /**
     * Render the LiveWire component.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|mixed
     */
    public function render()
    {
        return view('livewire.cms.privacy_details.privacy_details_index')
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
            'privacyPolicy.slug',
            'title',
            'content',
        ];
    }
}
