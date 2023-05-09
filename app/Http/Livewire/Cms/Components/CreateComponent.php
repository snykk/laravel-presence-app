<?php

namespace App\Http\Livewire\Cms\Components;

use App\Models\Component;

class CreateComponent extends ComponentForm
{
    /**
     * Define the current operation of the livewire component.
     * The valid options for operation values are: create, view, update.
     *
     * @var string
     */
    protected string $operation = 'create';

    /**
     * Render the LiveWire component.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|mixed
     */
    public function render()
    {
        return view('livewire.cms.components.create_component')
            ->extends('cms::_layouts.app')
            ->section('content');
    }
}
