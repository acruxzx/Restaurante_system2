<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoPedidoRequest extends FormRequest
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
			'id_precio' => 'required',
			'id_pedido' => 'required',
			'cantidad' => 'required',
            'observacion' => 'nullable|string|max:255',  // Campo opcional con máximo de 255 caracteres
        ];
    }
 

}
