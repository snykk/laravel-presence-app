<?php

namespace App\Http\Livewire\Cms\Departments;

class ShowDepartment extends DepartmentForm
{
    /**
     * Define the current operation of the livewire component.
     * The valid options for operation values are: create, view, update.
     *
     * @var string
     */
    protected string $operation = 'view';

    /**
     * Render the LiveWire component.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|mixed
     */
    public function render()
    {
        return view('livewire.cms.departments.show_department')
            ->extends('cms::_layouts.app')
            ->section('content');
    }
}
