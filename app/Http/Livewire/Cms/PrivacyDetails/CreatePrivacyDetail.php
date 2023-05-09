<?php

namespace App\Http\Livewire\Cms\PrivacyDetails;

use App\Models\PrivacyDetail;

class CreatePrivacyDetail extends PrivacyDetailForm
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
        $this->privacyDetail = new PrivacyDetail();

        parent::mount();
    }

    /**
     * Render the LiveWire component.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|mixed
     */
    public function render()
    {
        return view('livewire.cms.privacy_details.create_privacy_detail')
            ->extends('cms::_layouts.app')
            ->section('content');
    }
}
