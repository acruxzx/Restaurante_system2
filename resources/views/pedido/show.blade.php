@extends('layouts.app')

@section('template_title')
    Factura del Pedido
@endsection

@section('content')
<section class="content container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body bg-white p-2" style="max-width: 58mm; margin: 0 auto;">
                    <!-- Información del negocio -->
                    <div class="text-center mb-3">
                        <h3 style="font-size: 1rem; font-weight: bold;">Restaurante Delicia China</h3>
                        <p style="font-size: 0.8rem;">Juan Felipe Gelves Abril</p>
                        <p style="font-size: 0.8rem;">NIT: 1098784914-8</p>
                        <p style="font-size: 0.8rem;">Carrera 15 #4a, Piedecuesta, Santander</p>
                        <p style="font-size: 0.8rem;">Tel: +57 3154451249</p>
                        <p style="font-size: 0.8rem;">deliciachinapiedecuesta@gmail.com</p>
                        <p style="font-size: 0.8rem;">Régimen: No responsable de IVA</p>
                    </div>
                    <hr style="border-top: 1px solid #000; margin: 5px 0;">

                    <!-- Información del cliente -->
                    <div class="mb-3">
                        <p style="font-size: 0.8rem; font-weight: bold;">Cliente:</p>
                        <p style="font-size: 0.8rem;">Nombre: {{ $pedido->cliente->nombre }}</p>
                        <p style="font-size: 0.8rem;">Dirección: {{ $pedido->cliente->direccion }}</p>
                        <p style="font-size: 0.8rem;">Barrio: {{ $pedido->cliente->barrio }}</p>
                        <p style="font-size: 0.8rem;">Teléfono: {{ $pedido->cliente->telefono }}</p>
                        <p style="font-size: 0.8rem;">Tipo de pedido: {{ $pedido->tpPedido->tp_pedido }}</p>
                    </div>
                    <hr style="border-top: 1px solid #000; margin: 5px 0;">

                    <!-- Detalles del pedido -->
                    <div class="mb-3">
                        <table style="width: 100%; font-size: 0.7rem; border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th style="text-align: left; padding: 2px;">Cant</th>
                                    <th style="text-align: left; padding: 2px;">Producto</th>
                                    <th style="text-align: right; padding: 2px;">Descuento</th>
                                    <th style="text-align: right; padding: 2px;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $totalFactura = 0; @endphp
                                @foreach ($pedido->productoPedidos as $productoPedido)
                                    @php
                                        $nombreCompleto = $productoPedido->precio->producto->nombre;
                                        $codigoProducto = explode('.', $nombreCompleto)[0];
                                        $precioUnitario = $productoPedido->precio->precio;
                                        $cantidad = $productoPedido->cantidad;
                                        $descuento = $productoPedido->descuento; // Descuento aplicado al producto
                                        $totalConDescuento = ($precioUnitario * $cantidad) - (($descuento / 100) * ($precioUnitario * $cantidad)); // Cálculo con descuento
                                    @endphp
                                    <tr>
                                        <td style="padding: 2px;">{{ $productoPedido->cantidad }}</td>
                                        <td style="padding: 2px;">{{ $productoPedido->precio->tamanos->nombre }} {{ $codigoProducto }}</td>
                                        <td style="text-align: right; padding: 2px;">${{ number_format($descuento, 2) }}%</td>
                                        <td style="text-align: right; padding: 2px;">${{ number_format($totalConDescuento, 2) }}</td>
                                    </tr>
                                    @php $totalFactura += $totalConDescuento; @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                      <!-- Observaciones -->
                      <div class="mb-3">
                        <p style="font-size: 0.7rem; font-weight: bold; color: #050505;">Observaciones:</p>
                        <ul style="font-size: 0.7rem; list-style-type: none; padding: 0;">
                            @foreach ($pedido->productoPedidos as $productoPedido)
                                @if ($productoPedido->observacion)
                                    <li>{{ $productoPedido->observacion }}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                          

                    <!-- Total a pagar -->
                    <div class="mt-3">
                        <p style="font-size: 0.8rem; font-weight: bold;">Total a pagar: ${{ number_format($totalFactura, 2) }}</p>
                        <p style="font-size: 0.8rem;">Gracias por su compra. ¡Vuelva pronto!</p>
                    </div>
                    @if ($pedido->venta && $pedido->venta->mediosPago->isNotEmpty())
                    <div class="mt-2">
                        <p style="font-size: 0.8rem; font-weight: bold;">Medios de pago:</p>
                        <ul style="font-size: 0.8rem; list-style: none; padding: 0;">
                            @foreach ($pedido->venta->mediosPago as $medio)
                                @if ($medio->pivot && $medio->pivot->monto > 0)
                                    <li>{{ $medio->medio_pago }}: ${{ number_format($medio->pivot->monto, 0, ',', '.') }}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                    

                <!-- Botones -->
                <div class="card-footer text-center no-print" style="margin-top: 10px;">
                    <button onclick="window.print()" style="font-size: 0.8rem; padding: 5px 10px;">Imprimir Factura</button>
                    <a class="btn btn-primary" href="{{ route('pedidos.index') }}" style="font-size: 0.8rem; padding: 5px 10px;">Volver</a>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    @media print {
        .no-print {
            display: none;
        }
        body {
            margin: 0;
        }
        .card {
            box-shadow: none;
            border: none;
        }
    }
</style>
@endsection
