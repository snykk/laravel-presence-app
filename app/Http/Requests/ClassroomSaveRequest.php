<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassroomSaveRequest extends FormRequest
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
            'building_id' => 'required|integer|between:0,18446744073709551615',
            'room_number' => 'required|string|min:2|max:1',
            'capacity' => 'required|integer|between:0,65535',
            'floor' => 'required|integer|between:0,65535',
            'status' => 'required|string|min:2|max:255',
        ];
    }
}
