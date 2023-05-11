<?php

namespace App\Http\Livewire\Cms\Schedules;

use App\Models\Schedule;

class CreateSchedule extends ScheduleForm
{
    /**
     * Define the current operation of the livewire component.
     * The valid options for operation values are: create, view, update.
     *
     * @var string
     */
    protected string $operation = 'create';

    /**
     * Handle the `mount` lifecycle event.
     */
    public function mount(): void
    {
        $this->schedule = new Schedule();

        parent::mount();
    }

    /**
     * Render the LiveWire component.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|mixed
     */
    public function render()
    {
        return view('livewire.cms.schedules.create_schedule')
            ->extends('cms::_layouts.app')
            ->section('content');
    }
}
