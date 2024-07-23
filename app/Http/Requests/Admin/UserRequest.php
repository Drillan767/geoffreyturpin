<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
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
