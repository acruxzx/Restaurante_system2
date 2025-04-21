<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrecioRequest extends FormRequest
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
			'id_productos' => 'required',
			'precio' => 'required|numeric|min:0',
			'estado' => 'required',
            'id_tamanos' => 'required|exists:tamanos,id'

        ];
    }

    public function messages()
    {
        return [
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un valor numérico.',
            'precio.min' => 'El precio no puede ser negativo.',
        ];
    }
}
