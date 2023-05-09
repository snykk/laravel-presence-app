<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComponentSaveRequest extends FormRequest
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
            'published_at' => 'required|date',
            'name'         => 'required|string|min:2|max:255',
            'slug'         => 'required|string|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/|min:2|max:255',
        ];
    }
}
