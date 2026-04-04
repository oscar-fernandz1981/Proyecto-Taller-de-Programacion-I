<section class="container mt-5">
    <div class="row">
        <?php if (empty($ofertas)): ?>
            <div class="col-12 text-center">
                <h4 class="alert alert-info">¡Próximamente nuevas ofertas!</h4>
            </div>
        <?php else: ?>
            <?php foreach ($ofertas as $prod): 
                // Lógica de precios
                $precio_original = $prod['precio_vta'];
                $descuento = $prod['descuento_porcentaje'];
                $precio_final = $precio_original - ($precio_original * $descuento / 100);

                // Mapeo de categoría para el título de la card
                $cat_nombre = '';
                switch($prod['categoria_id']) {
                    case 1: $cat_nombre = 'Termos'; break;
                    case 2: $cat_nombre = 'Auriculares'; break;
                    case 3: $cat_nombre = 'Juguetería'; break;
                    default: $cat_nombre = 'Producto';
                }
            ?>
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="position-absolute top-0 end-0 p-2">
                            <span class="badge bg-danger shadow-sm"><?= $descuento ?>% OFF</span>
                        </div>
                        <img src="<?= base_url('assets/uploads/'.$prod['imagen']) ?>" 
                             style="height: 250px; object-fit: contain; background-color: #f8f9fa;" 
                             class="card-img-top p-2" alt="<?= $prod['nombre_prod'] ?>">
                        
                        <div class="card-body text-center">
                            <small class="text-uppercase text-muted fw-bold"><?= $cat_nombre ?></small>
                            <h5 class="card-title mt-1"><?= $prod['nombre_prod'] ?></h5>
                            
                            <p class="card-text mb-0">
                                <del class="text-muted small">$<?= number_format($precio_original, 2) ?></del>
                            </p>
                            <h4 class="text-success fw-bold">$<?= number_format($precio_final, 2) ?></h4>
                            
                            <div class="d-grid gap-2 mt-3">
                                <a href="<?= base_url('ProductoDetalle/'.$prod['id_producto'].'?from=promo');?>"
                                 class="btn btn-outline-primary btn-sm">Ver Detalle</a>
                                <a href="<?= base_url('login');?>" class="btn btn-success">Comprar</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>