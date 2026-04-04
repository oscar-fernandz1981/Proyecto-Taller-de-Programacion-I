<?php 
  $total_venta = 0; 
  $metodo_pago = ''; // Para usarlo en las instrucciones
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; font-size: 13px; color: #333; line-height: 1.4; }
        .invoice-header { text-align: center; background-color: #444; color: white; padding: 15px; border-radius: 5px; }
        .section-title { background-color: #eee; padding: 8px; border-bottom: 2px solid #444; font-weight: bold; margin-top: 20px; text-transform: uppercase; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 8px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f9f9f9; }
        .total-box { text-align: right; font-size: 18px; font-weight: bold; padding: 15px; background-color: #444; color: white; margin-top: 10px; }
        
        /* Estilo para la alerta de transferencia */
        .alerta-pago { margin-top: 25px; padding: 15px; border: 2px solid #d32f2f; background-color: #fdecea; color: #b71c1c; }
        .alerta-exito { margin-top: 25px; padding: 15px; border: 2px solid #2e7d32; background-color: #edf7ed; color: #1b5e20; }
    </style>
</head>
<body>

    <div class="invoice-header">
        <h1>Multirubro Blass</h1>
        <p>Comprobante de Operación</p>
    </div>

    <div class="section-title">Resumen del Cliente</div>
    <?php if($datos): ?>
        <?php foreach($datos as $vta): ?>
        <table>
            <tr>
                <td width="25%"><strong>Cliente:</strong></td>
                <td><?php echo strtoupper($vta['nombre'] . ' ' . $vta['apellido']); ?></td>
                <td width="20%"><strong>Fecha:</strong></td>
                <td><?php echo date('d/m/Y', strtotime($vta['fecha'])); ?></td>
            </tr>
            <tr>
                <td><strong>Pago:</strong></td>
                <td><?php echo $vta['tipo_pago']; ?></td>
                <td><strong>Pedido:</strong></td>
                <td>#<?php echo $vta['id']; ?></td>
            </tr>
        </table>
        <?php 
            $total_venta = $vta['total_venta']; 
            $metodo_pago = $vta['tipo_pago']; // Guardamos el método para la lógica de abajo
        ?>
        <?php endforeach; ?>
    <?php endif; ?>

    <div class="section-title">Productos Comprados</div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Descripción del Producto</th>
                <th style="text-align: center;">Cant.</th>
                <th>Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php if($ventas): ?>
                <?php foreach($ventas as $item): ?>
                <tr>
                    <td><?php echo $item['id_producto'] ?? $item['id']; ?></td>
                    <td><?php echo $item['nombre_prod'] ?? $item['nombre']; ?></td>
                    <td style="text-align: center;"><?php echo $item['cantidad']; ?></td>
                    <td>$<?php echo number_format($item['precio'], 2, ',', '.'); ?></td>
                    <td>$<?php echo number_format($item['total'], 2, ',', '.'); ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="total-box">
        TOTAL: ARS$ <?php echo number_format($total_venta, 2, ',', '.'); ?>
    </div>

    <?php if (trim(strtolower($metodo_pago)) == 'transferencia'): ?>
        <div class="alerta-pago">
            <strong>⚠️ ACCIÓN REQUERIDA (PAGO PENDIENTE):</strong><br>
            Para procesar su pedido, transfiera el total a:<br>
            <strong>Alias:</strong> multirubro.blass.mp <br>
            <strong>CBU:</strong> 0000003100012345678901 <br><br>
            Envíe este PDF y el comprobante por WhatsApp al <strong>3794766695</strong>.
        </div>
    <?php else: ?>
        <div class="alerta-exito">
            <strong> 👍 PAGO CONFIRMADO:</strong><br>
            Su transacción con tarjeta fue exitosa. Puede retirar su mercadería en el local con este comprobante o aguardar el envío a domicilio. ¡Gracias por su compra!
        </div>
    <?php endif; ?>

</body>
</html>