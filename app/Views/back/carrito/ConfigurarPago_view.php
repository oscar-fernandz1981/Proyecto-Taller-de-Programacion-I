<div class="container my-5 shadow p-4 rounded bg-white">
    <h2 class="text-center mb-4">Configuración de Pago</h2>
    
    <form id="formPago" action="<?= base_url('guarda_compra') ?>" method="post">
        <div class="row">
            <div class="col-md-7">
                <h4 class="mb-3">Seleccione Medio de Pago</h4>
                
                <div class="list-group mb-4">
                    <label class="list-group-item d-flex gap-3">
                        <input class="form-check-input flex-shrink-0" type="radio" name="metodoPago" id="pagoTarjeta" value="Tarjeta" checked onclick="alternarSecciones('seccionTarjeta')">
                        <span>
                            <strong>Tarjeta de Crédito / Débito</strong>
                            <small class="d-block text-muted">Acreditación instantánea</small>
                        </span>
                    </label>
                    <label class="list-group-item d-flex gap-3">
                        <input class="form-check-input flex-shrink-0" type="radio" name="metodoPago" id="pagoTransferencia" value="Transferencia" onclick="alternarSecciones('seccionTransferencia')">
                        <span>
                            <strong>Transferencia Bancaria</strong>
                            <small class="d-block text-muted">Debe enviar comprobante para validar</small>
                        </span>
                    </label>
                </div>

                <div id="seccionTarjeta" class="metodo-pago-box border p-3 rounded bg-light">
                    <h5>Datos de la Tarjeta</h5>
                    <div class="mb-3">
                        <label class="form-label">Número de Tarjeta</label>
                        <input type="text" class="form-control" placeholder="0000 0000 0000 0000" maxlength="16">
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">Vencimiento</label>
                            <input type="text" class="form-control" placeholder="MM/AA" maxlength="5">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Cód. Seguridad</label>
                            <input type="password" class="form-control" placeholder="123" maxlength="3">
                        </div>
                    </div>
                </div>

                <div id="seccionTransferencia" class="metodo-pago-box border p-3 rounded bg-light" style="display:none;">
                    <div class="alert alert-info">
                        <h5>Datos para la Transferencia</h5>
                        <p class="mb-1"><strong>CBU:</strong> 0000003100012345678901</p>
                        <p class="mb-1"><strong>Alias:</strong> multirubro.blass.mp</p>
                        <p class="mb-0"><strong>Titular:</strong> Blass Multirubro</p>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Resumen de Compra</h4>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Total a pagar:</span>
                            <span class="h4 text-success">$<?= number_format($cart->total(), 2); ?></span>
                        </div>
                        
                        <button type="button" id="btnConfirmar" class="btn btn-success btn-lg w-100" onclick="procesarSimulacion()">
                            Confirmar Compra
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Función para mostrar/ocultar secciones
function alternarSecciones(idMostrar) {
    document.querySelectorAll('.metodo-pago-box').forEach(el => el.style.display = 'none');
    document.getElementById(idMostrar).style.display = 'block';
}

// Simulación de Pago
function procesarSimulacion() {
    const metodo = document.querySelector('input[name="metodoPago"]:checked').value;

    Swal.fire({
        title: 'Validando datos...',
        text: 'Por favor, aguarde unos segundos.',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
    });

    // Espera de 3 segundos
    setTimeout(() => {
        Swal.fire({
            icon: 'success',
            title: '¡Operación correcta!',
            text: 'Su pago ha sido procesado con éxito.',
            showConfirmButton: false,
            timer: 2000
        }).then(() => {
            // Finalmente enviamos el formulario al controlador
            document.getElementById('formPago').submit();
        });
    }, 3000);
}
</script>