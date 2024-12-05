<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
            'title' => 'required|string|min:3|max:255',
            'year'  => 'required|string|min:4|max:4',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'O título é obrigatório',
            'title.string' => 'O título deve ser um texto',
            'title.min' => 'O título deve ter no mínimo 3 caracteres',
            'title.max' => 'O título deve ter no máximo 255 caracteres',

            'year.required' => 'A data é obrigatória',
            'year.string' => 'data deve ser um texto',
            'year.min' => 'data deve ter 4 caracteres',
            'year.max' => 'data deve ter 4 caracteres',

        ];
    }

}
