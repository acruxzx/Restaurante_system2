<?php

namespace App\Http\Controllers;

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
 use App\Models\Pedido;
    
    class FacturaController extends Controller
{
    public function imprimir($id)
    {
        // Recupera el pedido por su ID
        $pedido = Pedido::with('cliente', 'tpPedido', 'productoPedidos.precio.producto', 'venta.medioPago', 'userTrabajador')->findOrFail($id);

        // Datos que deseas enviar a la app Xprinter para impresión
        $datosImpresion = [
            'restaurante' => 'Restaurante Delicia China',
            'cliente' => $pedido->cliente->nombre,
            'direccion' => $pedido->cliente->direccion,
            'telefono' => $pedido->cliente->telefono,
            'pedido_id' => $pedido->id,
            'productos' => $pedido->productoPedidos->map(function ($productoPedido) {
                return [
                    'producto' => $productoPedido->precio->producto->nombre,
                    'cantidad' => $productoPedido->cantidad,
                    'precio' => $productoPedido->precio->precio,
                    'total' => $productoPedido->cantidad * $productoPedido->precio->precio
                ];
            }),
            'total' => $pedido->productoPedidos->sum(function ($productoPedido) {
                return $productoPedido->cantidad * $productoPedido->precio->precio;
            }),
            'trabajador' => $pedido->userTrabajador->nombre
        ];

        // URL de Xprinter Service (debe estar corriendo en la máquina donde está la impresora)
        $url = 'http://192.168.0.0:8000/api/imprimir';  // Cambia esta IP por la de tu servidor Xprinter

        // Enviar los datos de impresión a Xprinter Service mediante POST
        $response = Http::post($url, $datosImpresion);

        // Verificar si la solicitud fue exitosa
        if ($response->successful()) {
            return redirect()->route('pedidos.index')->with('success', 'Pedido impreso con éxito.');
        } else {
            return redirect()->route('pedidos.index')->with('error', 'Error al imprimir el pedido.');
        }
    }
}