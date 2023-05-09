<?php

namespace App\Http\Livewire\Cms\SecurityDetails;

use App\Models\SecurityDetail;

class CreateSecurityDetail extends SecurityDetailForm
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
        $this->securityDetail = new SecurityDetail();

        parent::mount();
    }

    /**
     * Render the LiveWire component.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|mixed
     */
    public function render()
    {
        return view('livewire.cms.security_details.create_security_detail')
            ->extends('cms::_layouts.app')
            ->section('content');
    }
}
