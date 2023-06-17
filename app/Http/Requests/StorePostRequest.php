<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required',
            'slug' => 'required|unique:posts,slug',
            'content' => 'required'
        ];
    }

    /**
     * Validation messages translated
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'title.required' => 'O campo título é obrigatório.',
            'slug.required' => 'O campo slug é obrigatório.',
            'slug.unique' => 'O campo slug deve ser único.',
            'content.required' => 'O campo conteúdo é obrigatório.'
        ];
    }
}
