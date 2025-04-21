<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-sm" style="background-color: #3f3e3e; color: rgb(69, 65, 65);">
                <div class="card-header" style="background-color: #060606; color: rgb(242, 239, 239);">
                    <h5 class="mb-0">Agregar Productos al Pedido</h5>
                </div>
                <div class="card-body">
                    <form id="form-agregar-producto">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="buscar-producto" class="form-label" style="color: white;">Buscar Producto</label>
                            <input type="text" class="form-control" id="buscar-producto" placeholder="Escribe para buscar un producto..." required style="background-color: #444; color: white; border: 1px solid #555;">
                        </div>

                        <div id="lista-productos" class="mb-4" style="max-height: 200px; overflow-y: auto; background-color: #222; padding: 10px; border-radius: 5px;"></div>

                        <input type="hidden" name="id_pedido" value="{{ $pedido->id }}" id="id_pedido">
                    </form>

                    <h5 class="mt-4" style="color: white;">Carrito de Productos</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-dark" id="carrito">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Porcentaje %</th>
                                    <th>Observación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="carrito-body"></tbody>
                        </table>
                    </div>
                    <div class="text-end">
                        <h4 id="total-factura" style="color: white;">Total: $0.00</h4>
                    </div>

                    <button type="button" id="btn-confirmar-carrito" class="btn btn-success btn-lg me-2" style="color: white;">
                        {{ __('Confirmar Carrito') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    const productos = [
        @foreach ($precios as $precio)
            { 
                label: '{{ $precio->producto->nombre }} ({{ $precio->tamanos->nombre }})',
                id: '{{ $precio->id }}',
                precio: '{{ $precio->precio }}',
                tamaño: '{{ $precio->tamanos->nombre }}'
            },
        @endforeach
    ];

    let carrito = [];

    // Buscar productos
    $('#buscar-producto').on('input', function () {
        const filtro = $(this).val().toLowerCase();
        let html = '';
        productos.forEach(producto => {
            if (producto.label.toLowerCase().includes(filtro)) {
                html += `
                    <div class="form-check">
                        <input class="form-check-input producto-checkbox" type="checkbox" value="${producto.id}" 
                            data-nombre="${producto.label}" data-precio="${producto.precio}">
                        <label class="form-check-label" style="color: white;">${producto.label} - $${producto.precio}</label>
                    </div>`;
            }
        });
        $('#lista-productos').html(html);
    });

    // Agregar o quitar productos del carrito
    $(document).on('change', '.producto-checkbox', function () {
        const id = $(this).val();
        const nombre = $(this).data('nombre');
        const precio = parseFloat($(this).data('precio'));

        if ($(this).is(':checked') && !carrito.some(p => p.id == id)) {
            carrito.push({ id, nombre, precio, cantidad: 1, descuento: 0, observacion: 'N/A' });

            const fila = `
                <tr data-id="${id}">
                    <td>${nombre}</td>
                    <td class="precio">$${precio.toFixed(2)}</td>
                    <td><input type="number" class="form-control cantidad" value="1" min="1" style="width: 60px;"></td>
                    <td><input type="number" class="form-control descuento" value="0" min="0" max="100" style="width: 60px;"></td>
                    <td><input type="text" class="form-control observacion" value="N/A" style="width: 100px;"></td>
                    <td><button type="button" class="btn btn-danger btn-sm eliminar-producto">Eliminar</button></td>
                </tr>`;
            $('#carrito-body').append(fila);
        } else if (!$(this).is(':checked')) {
            carrito = carrito.filter(p => p.id != id);
            $(`tr[data-id="${id}"]`).remove();
        }

        actualizarTotalFactura();
    });

    // Actualizar precio total en tiempo real
    $(document).on('input', '.cantidad, .descuento', function () {
        const row = $(this).closest('tr');
        const id = row.data('id');
        const cantidad = parseInt(row.find('.cantidad').val());
        const descuento = parseFloat(row.find('.descuento').val());
        const precioBase = carrito.find(p => p.id == id).precio;

        const precioFinal = precioBase * (1 - descuento / 100) * cantidad;
        row.find('.precio').text(`$${precioFinal.toFixed(2)}`);

        actualizarTotalFactura();
    });

    // Eliminar producto
    $(document).on('click', '.eliminar-producto', function () {
        const row = $(this).closest('tr');
        const id = row.data('id');
        carrito = carrito.filter(p => p.id != id);
        row.remove();
        $(`.producto-checkbox[value="${id}"]`).prop('checked', false);

        actualizarTotalFactura();
    });

    // Función para actualizar el total
    function actualizarTotalFactura() {
        let total = 0;
        let totalDescuento = 0;

        carrito.forEach(p => {
            const row = $(`tr[data-id="${p.id}"]`);
            const cantidad = parseInt(row.find('.cantidad').val());
            const descuento = parseFloat(row.find('.descuento').val());
            const precio = p.precio;

            const subtotal = precio * cantidad;
            const descuentoAplicado = subtotal * (descuento / 100);
            total += subtotal - descuentoAplicado;
            totalDescuento += descuentoAplicado;
        });

        $('#total-factura').html(`Total: $${total.toFixed(2)} <br> Descuento: $${totalDescuento.toFixed(2)}`);
    }

    // Confirmar carrito
    $('#btn-confirmar-carrito').on('click', function () {
        if (carrito.length === 0) {
            Swal.fire({ icon: 'warning', title: 'Carrito vacío', text: 'No hay productos en el carrito para confirmar.', confirmButtonText: 'Aceptar' });
            return;
        }

        const productosConfirmar = carrito.map(p => {
            const row = $(`tr[data-id='${p.id}']`);
            return {
                id_precio: p.id,
                cantidad: row.find('.cantidad').val(),
                descuento: row.find('.descuento').val(),
                observacion: row.find('.observacion').val()
            };
        });

        $.ajax({
            type: 'POST',
            url: '{{ route("producto-pedidos.store") }}',
            data: {
                '_token': '{{ csrf_token() }}',
                'id_pedido': $('#id_pedido').val(),
                'productos': productosConfirmar
            },
            success: function (data) {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Carrito confirmado!',
                        text: data.success,
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        window.location.href = `{{ url('ventas/create') }}/${$('#id_pedido').val()}`;
                    });
                }
            },
            error: function () {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Hubo un problema al procesar la solicitud.', confirmButtonText: 'Aceptar' });
            }
        });
    });
});
</script>
