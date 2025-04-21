<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PedidoRequest extends FormRequest
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
			'pedido' => 'required',
			'id_trabajador' => 'required',
			'id_cliente' => 'required|exists:clientes,id',
			'id_estadoPedido' => 'required',
			'id_tp_pedido' => 'required',
        ];
    }
    public function messages(): array
{
    return [
        'pedido.required' => 'El campo pedido es obligatorio.',
        'id_trabajador.required' => 'El campo trabajador es obligatorio.',
        'id_cliente.required' => 'Debe seleccionar un cliente.',
        'id_cliente.exists' => 'El cliente seleccionado no existe.',
        'id_estadoPedido.required' => 'El campo estado del pedido es obligatorio.',
        'id_tp_pedido.required' => 'El tipo de pedido es obligatorio.',
    ];
}
}
