
<br>
<div class="container p-3 mb-2 text-dark border-top border border-secondary rounded fondo2" style="width:50%;">
    <div class="container" align="center">
        
        <h2 id="h1" align='center' style="color: #000000;">¡Gracias! Tu compra ha sido realizada con éxito.</h2>
        <br>

        <?php if (isset($id_venta)): ?>
            <div class="alert alert-light border-success">
                <p>Tu número de pedido es: <strong>#<?= $id_venta ?></strong></p>
                <a href="<?= base_url('factura_cliente/'.$id_venta) ?>" class="btn btn-primary btn-lg" target="_blank">
                    <i class="bi bi-file-e                          |armark-pdf"></i> Descargar Factura (PDF)
                </a>
            </div>
        <?php endif; ?>

        <br>

        <input type="button" class='btn btn-outline-success' value="Volver a Inicio" onclick="window.location = '<?= base_url('panel') ?>'">

        <br><br>

        <div class="p-2 bg-light rounded border text-muted" style="font-size: 0.9rem;">
            <p class="mb-0">Si pagaste por <strong>Transferencia</strong>, recordá enviar el comprobante y la factura a:</p>
            <strong>WhatsApp: 3794766695</strong>
        </div>

    </div>
</div>
<br><br><br><br><br>