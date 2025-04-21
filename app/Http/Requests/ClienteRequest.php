<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Cliente; 

class ClienteRequest extends FormRequest
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
            'nombre' => 'required|string',
            'telefono' => 'required|string|regex:/^\d{10}$/', // Solo 10 dígitos permitidos
            'barrio' => 'nullable|string', // Campo opcional
            'direccion' => 'required|string',
            'notas' => 'nullable|string', // Campo opcional
        ];
    }
    
    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser una cadena de texto válida.',
    
            'telefono.required' => 'El número de teléfono es obligatorio.',
            'telefono.regex' => 'El número de teléfono debe contener solo dígitos y tener 10 caracteres.',

            'barrio.string' => 'El barrio debe ser una cadena de texto válida.',
            
            'direccion.required' => 'La dirección es obligatoria.',
            'direccion.string' => 'La dirección debe ser una cadena de texto válida.',
    
            'notas.string' => 'Las notas deben ser una cadena de texto válida.',
        ];
    }
    public function withValidator($validator)
{
    $validator->after(function ($validator) {
        $exists = Cliente::where('nombre', $this->nombre)
            ->where('telefono', $this->telefono)
            ->where('direccion', $this->direccion)
            ->exists();

        if ($exists) {
            $validator->errors()->add('nombre', 'El cliente ya existe con el mismo nombre, teléfono y dirección.');
        }
    });
}
}