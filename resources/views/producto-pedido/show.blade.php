@extends('layouts.app')

@section('template_title')
    Factura del Pedido
@endsection

@section('content')
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="float-left">
                        <h3 class="text-primary">Factura de Pedido</h3>
                    </div>
                    <div class="float-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('producto-pedidos.index') }}"> Volver</a>
                    </div>
                </div>

                <div class="card-body bg-white">
                    <!-- Información del negocio -->
                    <div class="invoice-header mb-4">
                        <h4 style="color: #dc3545;">Delicia China</h4>
                        <p>Dirección: Cra 15 N. 4A- 04 Piedecuesta</p>
                        <p>Teléfono: 6540689, 6542515, 3154451249.</p>
                        <hr>
                        <h5>Factura a nombre de: {{ $productoPedido->pedido->cliente->nombre }}</h5>
                        <p>Fecha: {{ date('d-m-Y') }}</p>
                    </div>

                    <!-- Detalles del pedido -->
                    <div class="invoice-details mb-4">
                        <h5 style="color: #28a745;">Detalles del Pedido</h5>
                        <table class="table table-bordered" style="border: 2px solid #343a40;">
                            <thead style="background-color: #343a40; color: white;">
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $totalFactura = 0; @endphp
                                <tr>
                                    <td>{{ $productoPedido->precio->producto->nombre }}</td>
                                    <td>{{ $productoPedido->cantidad }}</td>
                                    <td>${{ number_format($productoPedido->precio->precio, 2) }}</td>
                                    <td>${{ number_format($productoPedido->precio->precio * $productoPedido->cantidad, 2) }}</td>
                                </tr>
                                @php $totalFactura += $productoPedido->precio->precio * $productoPedido->cantidad; @endphp
                            </tbody>
                        </table>
                    </div>

                    <!-- Total de la factura -->
                    <div class="invoice-footer mt-4">
                        <h5 style="font-weight: bold; color: #dc3545;">Total a pagar: ${{ number_format($totalFactura, 2) }}</h5>
                        <p class="text-muted">Gracias por su compra en Delicia China. ¡Esperamos verle de nuevo!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection