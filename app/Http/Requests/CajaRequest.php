<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CajaRequest extends FormRequest
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
			'egreso' => 'required',
			'inicio' => 'required',
			'fin' => 'required',
			'id_trabajador' => 'required',
			'id_num_caja' => 'required',
        ];
    }
}
