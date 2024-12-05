<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthorRequest extends FormRequest
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
            'name'       => 'required|string|min:3|max:255',
            'birth_date' => 'required|string|min:10|max:10',
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

            'birth_date.required' => 'A data de nascimento é obrigatória',
            'birth_date.string' => 'data de nasciment deve ser um texto',
            'birth_date.min' => 'data de nasciment deve ter 10 caracteres',
            'birth_date.max' => 'data de nasciment deve ter 10 caracteres',

        ];
    }
}
