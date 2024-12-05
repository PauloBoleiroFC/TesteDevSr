<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'     => 'required|string|min:3|max:255',
            'email'    => 'required_without:id|email|unique:users|max:255',
            'password' => 'required|string|min:4|max:8',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'O nome é obrigatório',
            'name.string' => 'O nome deve ser um texto',
            'name.min' => 'O nome deve ter no mínimo 3 caracteres',
            'name.max' => 'O nome deve ter no máximo 255 caracteres',

            'email.required' => 'O email é obrigatório',
            'email.email' => 'O campo deve ser em formato de email ',
            'email.unique' => 'O campo email deve ser único ',

            'password.required' => 'A senha é obrigatório',
            'password.string' => 'A senha deve ser um texto',
            'password.min' => 'A senha deve ter no mínimo 4 caracteres',
            'password.max' => 'A senha deve ter no máximo 8 caracteres',

        ];
    }
}
