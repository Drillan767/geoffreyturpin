<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email:rfc,dns'],
            'description_fr' => ['required', 'string'],
            'description_en' => ['required', 'string'],
            'youtube' => ['required', 'string'],
            'linkedin' => ['required', 'string'],
            'facebook' => ['required', 'string'],
            'password' => ['nullable', 'confirmed']
        ];
    }
}
