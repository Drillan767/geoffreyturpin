<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
            'lang' => ['required', 'string'],
            'tags' => ['required', 'string'],
            'content' => ['required', 'string'],
            'draft' => ['required'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->has('editing') && !$this->hasFile('illustration')) {
                $validator->errors()->add('illustration', "Le champ est requis à la création de l'article");
            }
        });
    }
}
