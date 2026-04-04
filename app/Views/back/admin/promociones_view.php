<div class="container-fluid mt-5 fondo3 rounded">
    <br>
    <div class="row">
        <div class="col-md-8">
            <h3 class="Btext text-dark"> <i class="bi bi-tag-fill text-warning"></i> Productos en Promoción</h3>
        </div>
        <div class="col-md-4 text-end">
            <a href="<?= base_url('Lista_Productos'); ?>" class="btn btn-outline-primary btn-sm">Volver al Listado General</a>
        </div>
    </div>
    
    <div class="mt-3 text">
        <table class="table table-responsive table-hover align-middle" id="promo-list">
            <thead>
                <tr class="bg-warning text-dark">
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Precio Original</th>
                    <th>Descuento</th>
                    <th>Precio Final</th>
                    <th>Stock</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if($productos): ?>
                    <?php foreach($productos as $prod): ?>
                    <tr>
                        <td>
                            <img src="<?= base_url('assets/uploads/'.$prod['imagen']); ?>" 
                                 alt="<?= $prod['nombre_prod']; ?>" 
                                 class="rounded shadow-sm" 
                                 style="width: 60px; height: 60px; object-fit: cover;">
                        </td>
                        <td><strong><?= $prod['nombre_prod']; ?></strong></td>
                        <td><del class="text-muted">$<?= number_format($prod['precio_vta'], 2); ?></del></td>
                        <td><span class="badge bg-danger p-2"><?= $prod['descuento_porcentaje'] ?>% OFF</span></td>
                        <td>
                            <?php 
                                $descuento = ($prod['precio_vta'] * $prod['descuento_porcentaje']) / 100;
                                $precio_final = $prod['precio_vta'] - $descuento;
                            ?>
                            <span class="text-success fw-bold" style="font-size: 1.1rem;">
                                $<?= number_format($precio_final, 2) ?>
                            </span>
                        </td>
                        <td>
                            <span class="<?= ($prod['stock'] <= $prod['stock_min']) ? 'text-danger fw-bold' : '' ?>">
                                <?= $prod['stock']; ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-warning shadow-sm" href="<?= base_url('ProductoEdit/'.$prod['id_producto']);?>">
                                <i class="bi bi-pencil-square"></i> Ajustar Promo
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <p class="mb-0">No hay promociones activas actualmente.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready( function () {
        $('#promo-list').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
            },
            "pageLength": 10,
            "order": [[ 3, "desc" ]] // Ordena por porcentaje de descuento por defecto
        });
    });
</script>