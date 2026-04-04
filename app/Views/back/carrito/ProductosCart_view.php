<?php 
    $session = session();
    $nombre = $session->get('nombre');
    $perfil = $session->get('perfil_id');
    $id = $session->get('id');
    // Variable para verificar si hay sesión iniciada
    $is_logged = $session->has('login'); 
    $is_logged = ($session->get('id_usuario') || $session->get('perfil_id'));
?>

<div class="col-12 fondo4 container rounded">
<?php if (!$productos) { ?>
    <div class="container">
        <div class="well">
            <h1>No hay Productos Registrados</h1>
        </div>
    </div>
<?php } else { ?>

            <?php if (session()->getFlashdata('msg')): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-circle-fill me-2" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                    </svg>
                    <div>
                        <?= session()->getFlashdata('msg') ?>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    
    <br>    
    <h3 class="text-center Btext">Listado de Productos</h3>
    

    <div class="col-12 fondo4 container rounded">
    <br>    
    <!--<h3 class="text-center Btext">Listado de Productos</h3>-->

    <?php if (!$perfil): // Si no hay perfil_id en la sesión, es visitante ?>
        <div class="row justify-content-center mb-4">
            <div class="col-md-6">
                <form action="<?= base_url('catalogo') ?>" method="get">
                    <div class="input-group shadow-sm">
                        <input type="text" name="q" class="form-control" 
                               placeholder="¿Qué estás buscando? (Ej: termo, batman...)" 
                               value="<?= request()->getGet('q') ?>">
                        <button class="btn btn-primary" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                            </svg> Buscar
                        </button>
                    </div>
                </form>
                <?php if (request()->getGet('q')): ?>
                    <div class="text-center mt-2">
                        <a href="<?= base_url('catalogo') ?>" class="text-danger small">Limpiar búsqueda</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>


    <table class="table table-responsive table-hover fondo4" id="users-list">
        <thead>
            <tr class="bg-success">
                <th>Nombre</th>
                <th>Precio ARS$</th>
                <th>Categoría</th>
                <?php if ($is_logged): ?>
                    <th>Disponibles</th>
                <?php endif; ?>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($productos as $prod): ?>
            <tr>
                <td><?php echo $prod['nombre_prod']; ?></td>

                <td>
    <?php if ($prod['promo_activada'] == 1): ?>
        <?php 
            $original = $prod['precio_vta'];
            $porcentaje = $prod['descuento_porcentaje'];
            $precio_final = $original - ($original * $porcentaje / 100);
        ?>

        <?php if ($perfil == 1): // SI ES ADMIN ?>
            <div class="text-start">
                <span class="text-muted small">Base: $<?= number_format($original, 2); ?></span><br>
                <span class="badge bg-dark">-<?= $porcentaje ?>%</span><br>
                <b class="text-primary">P. Venta: $<?= number_format($precio_final, 2); ?></b>
            </div>

        <?php else: // SI ES CLIENTE O VISITANTE ?>
            <div class="d-flex flex-column">
                <del class="text-muted small">$<?= number_format($original, 2); ?></del>
                <span class="badge bg-danger mb-1" style="width: fit-content;"><?= $porcentaje ?>% OFF</span>
                <b class="text-success" style="font-size: 1.1rem;">$<?= number_format($precio_final, 2); ?></b>
            </div>
        <?php endif; ?>

    <?php else: ?>
        <span class="fw-bold">$<?= number_format($prod['precio_vta'], 2); ?></span>
    <?php endif; ?>
</td>

                <?php 
                    $categoria = 'Sin Categoría'; 
                    switch ($prod['categoria_id']) {
                        case 1: $categoria = 'Termos'; break;
                        case 2: $categoria = 'Auriculares'; break;
                        case 3: $categoria = 'Juguetes'; break;
                    }
                ?>
                <td><?php echo $categoria; ?></td>

                <?php if ($is_logged): ?>
                <td>
                    <?php
                    if ($prod['stock'] < $prod['stock_min'] && $prod['stock'] > 0) {
                        echo 'Producto debajo del Stock minimo: '.$prod['stock_min'];
                    } elseif ($prod['stock'] == 0) {
                        echo 'Sin Unidades';
                    } else {
                        echo $prod['stock'].' unidades';
                    }
                    ?>
                </td>
                <?php endif; ?>

                <td><img class="frmImg3" src="<?php echo base_url('assets/uploads/'.$prod['imagen']);?>" style="width: 70px;"></td>
                
                <td>
                    <div class="d-grid gap-2">
                        <a class="btn btn-outline-primary btn-sm" href="<?php echo base_url('ProductoDetalle/'.$prod['id_producto']);?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                            </svg> Mas Info
                        </a>

                        <?php if($prod['stock'] <= 0): ?>
                            <button class="btn btn-danger btn-sm" disabled>Sin Stock</button>
                        
                        <?php elseif ($is_logged): ?>
                            <?php if ($perfil == 2): ?>
                                <?php echo form_open('Carrito_agrega');
                                    echo form_hidden('id_producto', $prod['id_producto']);
                                    echo form_hidden('nombre_prod', $prod['nombre_prod']);
                                    echo form_hidden('precio_vta', $prod['precio_vta']);
                                    echo form_hidden('stock', $prod['stock']);
                                    
                                    $btn = array(
                                        'onclick'=> 'comprar()',
                                        'class' => 'btn btn-success btn-sm w-100',
                                        'value' => 'Comprar',
                                        'name' => 'action'
                                    );
                                    echo form_submit($btn);
                                    echo form_close();
                                ?>
                            <?php else: ?>
                                <span class="badge bg-info text-dark text-center">Admin Mode</span>
                            <?php endif; ?>

                        <?php else: ?>
                            <a href="<?php echo base_url('login');?>" class="btn btn-outline-success btn-sm">
                                ¿Desea Comprar?
                            </a>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php } ?>
</div>
</div> </div>