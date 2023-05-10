<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubjectGetRequest extends FormRequest
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
            'filter.id' => 'integer|between:0,18446744073709551615',
            'filter.department_id' => 'integer|between:0,18446744073709551615',
            'filter.code' => 'string|min:2|max:8',
            'filter.score_credit' => 'integer|between:0,65535',
            'filter.created_at' => 'date',
            'filter.updated_at' => 'date',
            'filter.subjects\.id' => 'integer|between:0,18446744073709551615',
            'filter.subjects\.department_id' => 'integer|between:0,18446744073709551615',
            'filter.subjects\.code' => 'string|min:2|max:8',
            'filter.subjects\.score_credit' => 'integer|between:0,65535',
            'filter.subjects\.created_at' => 'date',
            'filter.subjects\.updated_at' => 'date',
            'filter.department\.id' => 'integer|between:0,18446744073709551615',
            'filter.department\.code' => 'string|min:2|max:8',
            'filter.department\.created_at' => 'date',
            'filter.department\.updated_at' => 'date',
            'page.number' => 'integer|min:1',
            'page.size' => 'integer|between:1,100',
            'search' => 'nullable|string|min:3|max:60',
        ];
    }
}
