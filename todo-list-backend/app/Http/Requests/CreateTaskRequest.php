<?php

namespace App\Http\Requests;

class CreateTaskRequest extends ApiFormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'status' => 'required|string',
            'user_id' => 'required|exists:users,id'
        ];
    }

        public function messages()
    {
        return [
            'title.required' => 'El titulo es obligatorio.',
            'title.string' => 'El titulo debe ser una cadena de texto.',
            'description.string' => 'La descripcion debe ser una cadena de texto.',
            'description.max' => 'La descripcion no puede pasar los 2000 caracteres.',
            'status.required' => 'El status es obligatorio.',
            'status.string' => 'El status debe ser una cadena de texto.',
            'user_id.required' => 'El usuario es obligatorio.',
            'user_id.exists' => 'El usuario debe existir.',
        ];
    }
}
