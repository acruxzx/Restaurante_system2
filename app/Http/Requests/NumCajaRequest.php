<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NumCajaRequest extends FormRequest
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
            'caja' => 'required|string|regex:/^\S*$/', 
            'base_dia' => 'required|numeric|gt:0', // o la validación que necesites
            'base_noche' => 'required||numeric|gt:0',  // o la validación que necesites
            'base_inicial' => 'nullable|numeric',  // Esto hará que base_inicial no sea obligatorio 
        ];
    }
    
    public function messages()
    {
        return [
            'caja.regex' => 'el nombre de la caja no debe contener espacios',
            'base_dia.required' => 'La base inicial es obligatoria.',
            'base_dia.numeric' => 'La base inicial debe ser un número.',
            'base_dia.min' => 'La base inicial no puede ser negativa.',
            'base_dia.gt' => 'La base inicial debe ser mayor que 0.',
            'base_noche.required' => 'La base inicial es obligatoria.',
            'base_noche.numeric' => 'La base inicial debe ser un número.',
            'base_noche.min' => 'La base inicial no puede ser negativa.',
            'base_noche.gt' => 'La base inicial debe ser mayor que 0.',  
        ];
    }
    
}
