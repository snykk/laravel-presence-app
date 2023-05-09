<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrivacyPolicyGetRequest extends FormRequest
{
    /**
     * Determine if the current user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
//        return (auth()->guard('api')->check() || auth()->guard('cms-api')->check());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'filter.id'                             => 'integer|between:0,18446744073709551615',
            'filter.slug'                           => 'string|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/|min:2|max:255',
            'filter.order'                          => 'integer|between:0,4294967295',
            'filter.published'                      => 'boolean',
            'filter.published_at'                   => 'date',
            'filter.created_at'                     => 'date',
            'filter.updated_at'                     => 'date',
            'filter.privacy_policies\.id'           => 'integer|between:0,18446744073709551615',
            'filter.privacy_policies\.slug'         => 'string|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/|min:2|max:255',
            'filter.privacy_policies\.order'        => 'integer|between:0,4294967295',
            'filter.privacy_policies\.published'    => 'boolean',
            'filter.privacy_policies\.published_at' => 'date',
            'filter.privacy_policies\.created_at'   => 'date',
            'filter.privacy_policies\.updated_at'   => 'date',
            'page.number'                           => 'integer|min:1',
            'page.size'                             => 'integer|between:1,100',
            'search'                                => 'nullable|string|min:3|max:60',
        ];
    }
}
