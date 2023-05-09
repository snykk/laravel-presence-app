<?php

namespace App\Http\Livewire\Cms\Components;

use App\Http\Livewire\Cms\Extensions\PublishedDateColumn;
use App\Models\Component;
use Cms\Livewire\DatatableColumn;
use Cms\Livewire\DatatableComponent;
use Illuminate\Database\Eloquent\Builder;

class ComponentsIndex extends DatatableComponent
{
    use PublishedDateColumn;

    /**
     * Specify the datatable's columns and their behaviors.
     *
     * @return array
     */
    public function columns(): array
    {
        $typeOptions = Component::TYPES;

        return $this->applyColumnVisibility([
            DatatableColumn::make('id'),
            DatatableColumn::make('type')->renderWith(function ($model) use ($typeOptions) {
                return $typeOptions[$model->type];
            }),
            DatatableColumn::make('name'),
            DatatableColumn::make('slug'),
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
        return 'cms.components.';
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
                'title' => 'Components',
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
        return (new Component())
            ->newQuery()
            ->joinTranslation();
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
            route($this->getBaseRouteName().$action, ['componentId' => $key])
        );
    }

    /**
     * Render the LiveWire component.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|mixed
     */
    public function render()
    {
        return view('livewire.cms.components.components_index')
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
            'translations.name',
            'translations.slug',
            'translations.title',
        ];
    }
}
