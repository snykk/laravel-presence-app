<?php

namespace App\Http\Livewire\Cms\PrivacyPolicies;

use App\Models\PrivacyPolicy;

class CreatePrivacyPolicy extends PrivacyPolicyForm
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
    public function mount(int $privacyPolicyId = 0): void
    {
        parent::mount($privacyPolicyId);
        $this->privacyPolicy = new PrivacyPolicy();
    }

    /**
     * Render the LiveWire component.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|mixed
     */
    public function render()
    {
        return view('livewire.cms.privacy_policies.create_privacy_policy')
            ->extends('cms::_layouts.app')
            ->section('content');
    }
}