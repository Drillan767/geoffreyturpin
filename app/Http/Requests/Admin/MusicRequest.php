<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MusicRequest extends FormRequest
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
            'title' => ['required', 'string'],
            'year' => ['required', 'regex:/^\d{4}$/'],
            'author' => ['required', 'string'],
            'subtitle' => ['nullable', 'string'],
            'content_fr' => ['required', 'min:10'],
            'content_en' => ['required', 'min:10'],
            'iframe' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'year.regex' => "Le champ année doit être constitué de 4 nombres uniquement (ex: " . date('Y') .")."
        ];
    }
}

