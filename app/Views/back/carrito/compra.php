<?php 
$cart = \Config\Services::cart(); 
$session = session();
$nombre = $session->get('nombre');
$apellido = $session->get('apellido');
$email = $session->get('email');

$gran_total = 0;
if ($cart):
    foreach ($cart->contents() as $item):
        $gran_total += $item['subtotal'];
    endforeach;
endif;
?>

<div class="container p-3 mb-2 text-dark border-top border border-secondary rounded fondo2" style="max-width: 500px; background-color: #f8f9fa;">
    <div id="formulario-compra">
        <?php echo form_open("confirma_compra", ['class' => 'form-signin', 'id' => 'form-compra']); ?>
        
        <h2 class="text-center mb-4"><u>Resumen de la Compra</u></h2>

        <div class="table-responsive">
            <table class="table table-sm">
                <tr>
                    <td><strong>Total:</strong></td>
                    <td><span class="badge bg-success" style="font-size: 1.1rem;">$<?php echo number_format($gran_total, 2, ',', '.'); ?></span></td>
                </tr>
                <tr>
                    <td><strong>Cliente:</strong></td>
                    <td><?php echo $nombre . ' ' . $apellido; ?></td>
                </tr>
                <tr>
                    <td><strong>Email:</strong></td>
                    <td><?php echo $email; ?></td>
                </tr>
            </table>
        </div>

        <hr>

        <div class="mb-3">
            <label class="form-label"><strong>Seleccione Medio de Pago:</strong></label>
            <select name="tipo_pago" id="select-pago" class="form-select" onchange="gestionarCampos()">
                <option value="Efectivo" selected>Efectivo</option>
                <option value="T_Debito">Tarjeta de Débito</option>
                <option value="T_Credito">Tarjeta de Crédito</option>
                <option value="Transferencia">Transferencia Bancaria</option>
            </select>
        </div>

        <div id="seccion-tarjeta" style="display:none;" class="p-3 mb-3 border rounded bg-white shadow-sm">
            <h6 class="text-muted border-bottom pb-2">Datos de la Tarjeta</h6>
            
            <div class="mb-2">
                <label class="small">Número de Tarjeta</label>
                <input type="text" id="num_tarjeta" class="form-control" placeholder="0000 0000 0000 0000" maxlength="16">
            </div>
            
            <div class="row">
                <div class="col-6 mb-2">
                    <label class="small">Vencimiento</label>
                    <input type="text" id="vence_tarjeta" class="form-control" placeholder="MM/AA" maxlength="5">
                </div>
                <div class="col-6 mb-2">
                    <label class="small">Cód. Seguridad</label>
                    <input type="password" id="cvv_tarjeta" class="form-control" placeholder="CVV" maxlength="4">
                </div>
            </div>
            <p class="text-muted" style="font-size: 0.7rem;">* Esta es una simulación segura. Los datos no se almacenan.</p>
        </div>

        <div id="procesando-pago" style="display:none;" class="text-center my-4 p-4 border rounded bg-white">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <h5 id="texto-estado" class="mt-3 text-secondary">Validando con la entidad emisora...</h5>
        </div>

        <div id="botones-contenedor">
            <button type="submit" class="btn btn-success w-100 mb-2">Confirmar Compra</button>
            <a class="btn btn-outline-primary w-100" href="<?php echo base_url('CarritoList') ?>">Volver al Carrito</a>
        </div>

        <?php echo form_close(); ?>
    </div>
</div>

<script>
/**
 * Muestra u oculta los campos de tarjeta según la elección
 */
function gestionarCampos() {
    const metodo = document.getElementById('select-pago').value;
    const seccion = document.getElementById('seccion-tarjeta');
    
    if (metodo === 'T_Debito' || metodo === 'T_Credito') {
        seccion.style.display = 'block';
    } else {
        seccion.style.display = 'none';
    }
}

/**
 * Lógica de validación y simulación de espera
 */
document.getElementById('form-compra').onsubmit = function(e) {
    const metodo = document.getElementById('select-pago').value;

    // Solo simulamos si es tarjeta
    if (metodo === 'T_Debito' || metodo === 'T_Credito') {
        e.preventDefault(); // Detener envío real

        // 1. Validaciones básicas
        const tarjeta = document.getElementById('num_tarjeta').value;
        const vence = document.getElementById('vence_tarjeta').value;
        const cvv = document.getElementById('cvv_tarjeta').value;

        if (tarjeta.length < 16 || isNaN(tarjeta)) {
            alert("Ingrese los 16 números de su tarjeta.");
            return false;
        }
        if (vence.length < 5 || !vence.includes('/')) {
            alert("Formato de fecha inválido (MM/AA).");
            return false;
        }
        if (cvv.length < 3) {
            alert("Código de seguridad inválido.");
            return false;
        }

        // 2. Iniciar Simulación Visual
        const botones = document.getElementById('botones-contenedor');
        const pantalla = document.getElementById('procesando-pago');
        const texto = document.getElementById('texto-estado');
        const form = this;

        botones.style.display = 'none';
        document.getElementById('seccion-tarjeta').style.display = 'none';
        document.querySelector('.table-responsive').style.display = 'none';
        pantalla.style.display = 'block';

        // 3. Tiempos de espera (Simulación real)
        setTimeout(() => {
            texto.innerText = "Datos validados satisfactoriamente...";
            texto.classList.replace('text-secondary', 'text-success');
            
            setTimeout(() => {
                texto.innerText = "Finalizando transacción...";
                
                setTimeout(() => {
                    form.submit(); // Envío final al controlador
                }, 1000);
                
            }, 1500);

        }, 2500);
    }
};
</script>