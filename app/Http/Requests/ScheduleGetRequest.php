<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleGetRequest extends FormRequest
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
            'filter.seq' => 'integer|between:0,65535',
            'filter.start_time' => 'date',
            'filter.end_time' => 'date',
            'filter.created_at' => 'date',
            'filter.updated_at' => 'date',
            'filter.schedules\.id' => 'integer|between:0,18446744073709551615',
            'filter.schedules\.seq' => 'integer|between:0,65535',
            'filter.schedules\.start_time' => 'date',
            'filter.schedules\.end_time' => 'date',
            'filter.schedules\.created_at' => 'date',
            'filter.schedules\.updated_at' => 'date',
            'page.number' => 'integer|min:1',
            'page.size' => 'integer|between:1,100',
            'search' => 'nullable|string|min:3|max:60',
        ];
    }
}
