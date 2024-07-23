<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BiographyRequest extends FormRequest
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
            'date' => ['required', 'regex:/^\d{4}$/'],
            'text_fr' => ['required', 'string'],
            'text_en' => ['required', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'year.regex' => "Le champ année doit être constitué de 4 nombres uniquement (ex: " . date('Y') .")."
        ];
    }
}
