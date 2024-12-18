<?php

namespace App\Http\Livewire\Cms\Admins;

use App\Rules\DigitExists;
use App\Rules\LowerCaseExists;
use App\Rules\SpecialCharExists;
use App\Rules\UpperCaseExists;

class EditAdmin extends AdminForm
{
    /**
     * Define the current operation of the livewire component.
     * The valid options for operation values are: create, view, update.
     *
     * @var string
     */
    protected string $operation = 'update';

    /**
     * The validation rules for admin model.
     *
     * @return array
     */
    protected function rules(): array
    {
        $rules = parent::rules();
        $rules['data.password'] = [
            'nullable', 'string', 'min:8', 'confirmed',
            new UpperCaseExists(), new LowerCaseExists(), new DigitExists(), new SpecialCharExists(),
        ];
        $rules['data.password_confirmation'] = ['nullable', 'string'];

        return $rules;
    }

    /**
     * Render the LiveWire component.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|mixed
     */
    public function render()
    {
        return view('livewire.cms.admins.edit_admin')
            ->extends('cms::_layouts.app')
            ->section('content');
    }
}
