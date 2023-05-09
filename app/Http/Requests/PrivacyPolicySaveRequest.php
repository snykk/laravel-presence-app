<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrivacyPolicySaveRequest extends FormRequest
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
            'slug'         => 'required|string|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/|min:2|max:255',
            'order'        => 'required|integer|between:0,4294967295',
            'published_at' => 'required|date',
        ];
    }
}
