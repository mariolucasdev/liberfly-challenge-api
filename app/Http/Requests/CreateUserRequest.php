<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8'
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
            'name.required' => 'O campo nome é obrigatório.',
            'email.required' => 'O campo email é obrigatório',
            'email.email' => 'O campo e-mail deve ser um e-mail válido.',
            'email.unique' => 'E-mail já cadastrado, tente outro.',
            'password.required' => 'O campo senha é obrigatório',
            'password.min' => 'O campo senha deve conter no mínimo 8 carácteres'
        ];
    }
}
