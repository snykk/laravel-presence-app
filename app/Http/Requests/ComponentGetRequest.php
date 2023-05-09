<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComponentGetRequest extends FormRequest
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
            'filter.id'                       => 'integer|between:0,18446744073709551615',
            'filter.published_at'             => 'date',
            'filter.name'                     => 'string|min:2|max:255',
            'filter.slug'                     => 'string|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/|min:2|max:255',
            'filter.created_at'               => 'date',
            'filter.updated_at'               => 'date',
            'filter.deleted_at'               => 'date',
            'filter.components\.id'           => 'integer|between:0,18446744073709551615',
            'filter.components\.published_at' => 'date',
            'filter.components\.name'         => 'string|min:2|max:255',
            'filter.components\.slug'         => 'string|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/|min:2|max:255',
            'filter.components\.created_at'   => 'date',
            'filter.components\.updated_at'   => 'date',
            'filter.components\.deleted_at'   => 'date',
            'page.number'                     => 'integer|min:1',
            'page.size'                       => 'integer|between:1,100',
            'search'                          => 'nullable|string|min:3|max:60',
        ];
    }
}
