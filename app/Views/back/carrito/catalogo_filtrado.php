<div class="container mt-5 mb-5">
    <div class="row border-bottom mb-4">
        <div class="col-12 text-center">
            <h2 class="display-5 text-uppercase fw-bold text-primary"><?= $titulo ?></h2>
        </div>
    </div>

    <?php if (!empty($productos)): ?>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach($productos as $prod): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm border-0">
                        
                        <div class="d-flex justify-content-center align-items-center bg-light rounded-top" style="height: 200px; overflow: hidden;">
                            <img src="<?= base_url('assets/uploads/'.$prod['imagen']) ?>" 
                                 class="img-fluid p-2" 
                                 alt="<?= $prod['nombre_prod'] ?>" 
                                 style="max-height: 100%; width: auto; object-fit: contain;">
                        </div>
                        <div class="card-body text-center d-flex flex-column">
                            <h5 class="card-title text-capitalize fw-bold"><?= $prod['nombre_prod'] ?></h5>
                            
                            <p class="card-text text-muted small mb-2">
                                Disponibilidad: <?= $prod['stock'] ?> unidades
                            </p>
                            
                            <div class="mt-auto">
                                <h4 class="text-dark fw-bold">$<?= number_format($prod['precio'], 2, ',', '.') ?></h4>
                                <a href="<?= base_url('ProductoDetalle/'.$prod['id_producto']) ?>" class="btn btn-outline-primary w-100 mt-2">
                                    <i class="bi bi-eye"></i> Ver Detalles
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="row justify-content-center">
            <div class="col-md-6 text-center py-5">
                <div class="alert alert-info shadow-sm">
                    <i class="bi bi-info-circle-fill fs-2 d-block mb-3"></i>
                    <h4>Sin stock momentáneo</h4>
                    <p>Actualmente no hay productos disponibles en la categoría <strong><?= $titulo ?></strong>.</p>
                    <a href="<?= base_url('/') ?>" class="btn btn-primary mt-3">Volver al Inicio</a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>