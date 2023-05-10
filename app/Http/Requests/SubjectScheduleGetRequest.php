<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubjectScheduleGetRequest extends FormRequest
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
            'filter.subject_id' => 'integer|between:0,18446744073709551615',
            'filter.schedule_id' => 'integer|between:0,18446744073709551615',
            'filter.created_at' => 'date',
            'filter.updated_at' => 'date',
            'filter.subject_schedule\.id' => 'integer|between:0,18446744073709551615',
            'filter.subject_schedule\.subject_id' => 'integer|between:0,18446744073709551615',
            'filter.subject_schedule\.schedule_id' => 'integer|between:0,18446744073709551615',
            'filter.subject_schedule\.created_at' => 'date',
            'filter.subject_schedule\.updated_at' => 'date',
            'filter.subject\.id' => 'integer|between:0,18446744073709551615',
            'filter.subject\.department_id' => 'integer|between:0,18446744073709551615',
            'filter.subject\.code' => 'string|min:2|max:8',
            'filter.subject\.score_credit' => 'integer|between:0,65535',
            'filter.subject\.created_at' => 'date',
            'filter.subject\.updated_at' => 'date',
            'filter.schedule\.id' => 'integer|between:0,18446744073709551615',
            'filter.schedule\.seq' => 'integer|between:0,65535',
            'filter.schedule\.start_time' => 'date',
            'filter.schedule\.end_time' => 'date',
            'filter.schedule\.created_at' => 'date',
            'filter.schedule\.updated_at' => 'date',
            'page.number' => 'integer|min:1',
            'page.size' => 'integer|between:1,100',
            'search' => 'nullable|string|min:3|max:60',
        ];
    }
}
