<form action="{{ route('ventas.store') }}" method="POST">
    @csrf

    <!-- Medio de Pago -->
    <div class="form-group">
        <label for="id_medio_pago" class="form-label" style="color: #000000; font-weight: bold;">
            {{ __('Medio de Pago') }}
        </label>
        <select name="id_medioPago[]" class="form-control" id="id_medio_pago" style="border-radius: 5px; border: 1px solid #FFD700;">
            <option value="">-- Selecciona un medio de pago --</option>
            @foreach ($medioPagos as $medioPago)
                <option value="{{ $medioPago->id }}" data-nombre="{{ $medioPago->medio_pago }}">{{ $medioPago->medio_pago }}</option>
            @endforeach
            <option value="combinado" data-nombre="Combinado">Combinado</option>
        </select>
        <small>
            <a href="{{ route('medio-pagos.create') }}" class="text-decoration-none" style="font-size: 0.85rem; color: #FFD700;">
                Agregar nuevo medio de pago
            </a>
        </small>
    </div>

    <!-- Contenedor de medios combinados -->
    <div id="combinado-container" style="display: none; margin-top: 10px; border: 1px solid #FFD700; padding: 10px; border-radius: 5px;">
        <h5 style="color: #000000;">Detalle de Pago Combinado</h5>
        <div id="combinado-items"></div>
        <button type="button" id="add-payment" class="btn btn-sm" style="background-color: #FFD700; color: #000000; margin-top: 5px;">Añadir Medio de Pago</button>
        <div id="combinado-error" class="invalid-feedback" style="display: none; color: red;">
            El total de los medios de pago combinados no coincide con el total de la venta.
        </div>
    </div>

    <!-- Caja -->
    <div class="form-group">
        <label for="id_caja" class="form-label" style="color: #000000; font-weight: bold;">{{ __('Caja') }}</label>
        <select name="id_caja" class="form-control" id="id_caja" style="border-radius: 5px; border: 1px solid #FFD700;">
            @foreach ($cajas as $caja)
                <option value="{{ $caja->id }}">{{ $caja->caja }}</option>
            @endforeach
        </select>
    </div>

    <!-- Pedido oculto -->
    <input type="hidden" name="id_pedido" value="{{ old('id_productoPedido', $pedidoId) }}">

    <!-- Total -->
    <div class="form-group">
        <label for="total" class="form-label" style="color: #000000; font-weight: bold;">{{ __('Total') }}</label>
        <input type="number" name="total" class="form-control @error('total') is-invalid @enderror" id="total" value="{{ old('total', $totalFactura) }}" step="0.01" readonly style="border-radius: 5px; border: 1px solid #FFD700;">
        {!! $errors->first('total', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
    </div>

    <!-- Total original oculto -->
<input type="hidden" id="total-original" value="{{ old('total', $totalFactura) }}">
<!-- Descuento visible -->
<div id="descuento-info" style="color: green; font-weight: bold; margin-top: 5px; display: none;"></div>


    <!-- Botones -->
    <div class="text-center" style="margin-top: 20px;">
        <button type="submit" id="submit-button" class="btn" style="background-color: #FFD700; color: #000000; border-radius: 5px; padding: 12px 30px; font-size: 1.2rem; font-weight: bold;">
            {{ __('Registrar Venta') }}
        </button>
        <a href="{{ route('pedidos.index') }}" class="btn" style="background-color: #000000; color: #FFD700; border-radius: 5px; padding: 12px 30px; font-size: 1.2rem; font-weight: bold; margin-left: 15px;">
            {{ __('Cancelar') }}
        </a>
    </div>

    <div id="medio-pago-error" class="invalid-feedback" style="display: none; color: red; margin-top: 5px;">
        Debes seleccionar un medio de pago antes de registrar la venta.
    </div>
    
</form>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const medioPagoSelect = document.getElementById("id_medio_pago");
    const combinadoContainer = document.getElementById("combinado-container");
    const combinadoItems = document.getElementById("combinado-items");
    const addPaymentButton = document.getElementById("add-payment");
    const totalInput = document.getElementById("total");
    const totalOriginalInput = document.getElementById("total-original");
    const descuentoInfo = document.getElementById("descuento-info");
    const submitButton = document.getElementById("submit-button");
    const combinadoError = document.getElementById("combinado-error");
    const medioPagoError = document.getElementById("medio-pago-error");

    medioPagoSelect.addEventListener("change", function() {
        medioPagoError.style.display = "none";
        const selectedOption = medioPagoSelect.options[medioPagoSelect.selectedIndex];
        const totalOriginal = parseFloat(totalOriginalInput.value);

        if (selectedOption.dataset.nombre === "Combinado") {
            combinadoContainer.style.display = "block";
            medioPagoSelect.name = "";
            totalInput.value = totalOriginal.toFixed(2);
            descuentoInfo.style.display = "none";
        } else {
            combinadoContainer.style.display = "none";
            combinadoItems.innerHTML = "";
            combinadoError.style.display = "none";
            medioPagoSelect.name = "id_medioPago[]";

            if (selectedOption.dataset.nombre.toLowerCase() === "tarjeta") {
                const descuento = totalOriginal * 0.03;
                const totalConDescuento = totalOriginal - descuento;
                totalInput.value = totalConDescuento.toFixed(2);
                descuentoInfo.innerText = `Descuento aplicado: -$${descuento.toFixed(2)} (3% por pago con tarjeta)`;
                descuentoInfo.style.display = "block";
            } else {
                totalInput.value = totalOriginal.toFixed(2);
                descuentoInfo.style.display = "none";
            }
        }
    });

    addPaymentButton.addEventListener("click", function() {
        const newPaymentRow = document.createElement("div");
        newPaymentRow.classList.add("d-flex", "align-items-center", "mb-2");

        newPaymentRow.innerHTML = `
            <select name="id_medioPago[]" class="form-control medio-pago-combinado" style="width: 45%; margin-right: 10px;">
                @foreach ($medioPagos as $medioPago)
                    <option value="{{ $medioPago->id }}" data-nombre="{{ $medioPago->medio_pago }}">{{ $medioPago->medio_pago }}</option>
                @endforeach
            </select>
            <input type="number" name="monto_combinado[]" class="form-control" placeholder="Monto" style="width: 45%;" step="0.01">
            <button type="button" class="btn btn-danger btn-sm remove-payment" style="margin-left: 10px;">X</button>
        `;

        combinadoItems.appendChild(newPaymentRow);

        newPaymentRow.querySelector(".remove-payment").addEventListener("click", function() {
            newPaymentRow.remove();
            validateTotalPayment();
        });

        newPaymentRow.querySelector(".medio-pago-combinado").addEventListener("change", validateTotalPayment);
        newPaymentRow.querySelector('input[name="monto_combinado[]"]').addEventListener("input", validateTotalPayment);
    });

    submitButton.addEventListener("click", function(event) {
        const selectedOption = medioPagoSelect.options[medioPagoSelect.selectedIndex];

        if (!selectedOption.value) {
            medioPagoError.style.display = "block";
            event.preventDefault();
            return;
        }

        if (selectedOption.dataset.nombre === "Combinado") {
            validateTotalPayment(event);
        }
    });

    function validateTotalPayment(event = null) {
        let totalAmount = 0;
        let tieneTarjeta = false;
        const totalOriginal = parseFloat(totalOriginalInput.value);
        const montoInputs = document.querySelectorAll('input[name="monto_combinado[]"]');
        const medioSelects = document.querySelectorAll('.medio-pago-combinado');

        montoInputs.forEach((input, i) => {
            const monto = parseFloat(input.value) || 0;
            totalAmount += monto;

            const medio = medioSelects[i];
            const selectedOption = medio.options[medio.selectedIndex];
            if (selectedOption.dataset.nombre && selectedOption.dataset.nombre.toLowerCase() === "tarjeta") {
                tieneTarjeta = true;
            }
        });

        const totalVenta = totalOriginal;
        if (totalAmount.toFixed(2) !== totalVenta.toFixed(2)) {
            combinadoError.style.display = "block";
            descuentoInfo.style.display = "none";
            if (event) event.preventDefault();
        } else {
            combinadoError.style.display = "none";

            if (tieneTarjeta) {
                const descuento = totalVenta * 0.03;
                const totalConDescuento = totalVenta - descuento;
                totalInput.value = totalConDescuento.toFixed(2);
                descuentoInfo.innerText = `Descuento aplicado: -$${descuento.toFixed(2)} (3% por incluir tarjeta)`;
                descuentoInfo.style.display = "block";
            } else {
                totalInput.value = totalVenta.toFixed(2);
                descuentoInfo.style.display = "none";
            }
        }
    }
});
</script>
