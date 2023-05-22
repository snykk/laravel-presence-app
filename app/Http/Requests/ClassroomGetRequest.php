<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassroomGetRequest extends FormRequest
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
            'filter.building_id' => 'integer|between:0,18446744073709551615',
            'filter.room_number' => 'string|min:2|max:1',
            'filter.capacity' => 'integer|between:0,65535',
            'filter.floor' => 'integer|between:0,65535',
            'filter.status' => 'string|min:2|max:255',
            'filter.created_at' => 'date',
            'filter.updated_at' => 'date',
            'filter.classrooms\.id' => 'integer|between:0,18446744073709551615',
            'filter.classrooms\.building_id' => 'integer|between:0,18446744073709551615',
            'filter.classrooms\.room_number' => 'string|min:2|max:1',
            'filter.classrooms\.capacity' => 'integer|between:0,65535',
            'filter.classrooms\.floor' => 'integer|between:0,65535',
            'filter.classrooms\.status' => 'string|min:2|max:255',
            'filter.classrooms\.created_at' => 'date',
            'filter.classrooms\.updated_at' => 'date',
            'filter.building\.id' => 'integer|between:0,18446744073709551615',
            'filter.building\.name' => 'string|min:2|max:60',
            'filter.building\.address' => 'string|min:2|max:255',
            'filter.building\.created_at' => 'date',
            'filter.building\.updated_at' => 'date',
            'page.number' => 'integer|min:1',
            'page.size' => 'integer|between:1,100',
            'search' => 'nullable|string|min:3|max:60',
        ];
    }
}
