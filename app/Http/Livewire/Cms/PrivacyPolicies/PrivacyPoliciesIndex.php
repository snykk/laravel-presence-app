<?php

namespace App\Http\Livewire\Cms\PrivacyPolicies;

use App\Models\PrivacyPolicy;
use Carbon\Carbon;
use Cms\Livewire\DatatableColumn;
use Cms\Livewire\DatatableComponent;
use Illuminate\Database\Eloquent\Builder;

class PrivacyPoliciesIndex extends DatatableComponent
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
            DatatableColumn::make('slug'),
            DatatableColumn::make('is_private')->renderWith(function ($model) {
                if ($model->is_private == false) {
                    return 'No';
                }

                return 'Yes';
            })->setTitle('Private'),
            DatatableColumn::make('order'),
            DatatableColumn::make('published_at')->renderWith(function ($q) {
                return Carbon::parse($q->published_at)->format('d-m-Y');
            }),
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
        return 'cms.privacy_policies.';
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
                'title' => 'Privacy Policies',
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
        return (new PrivacyPolicy())
            ->newQuery();
    }

    /**
     * Render the LiveWire component.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|mixed
     */
    public function render()
    {
        return view('livewire.cms.privacy_policies.privacy_policies_index')
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
            'slug',
        ];
    }

    /**
     * Perform a specific action for the given record key.
     *
     * @param string      $action
     * @param string|null $key
     *
     * @return mixed
     */
    public function performAction(string $action, string $key = null)
    {
        return redirect()->to(
            route($this->getBaseRouteName().$action, ['privacyPolicyId' => $key])
        );
    }
}
