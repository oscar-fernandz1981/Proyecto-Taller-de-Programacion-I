<?php if(session()->getFlashdata('success')): ?>
    <div class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
            <strong><?= session()->getFlashdata('success'); ?></strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
<?php endif; ?> 

<div class="container-fluid mt-5 fondo3 rounded">
    <br>
    <a class="btn btn-success float-end" href="<?= base_url('nuevoProducto');?>">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-plus-fill" viewBox="0 0 16 16">
            <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM8.5 7v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 1 0z"/>
        </svg> Agregar Producto
    </a>
    <a class="btn btn-danger float-end me-2" href="<?= base_url('eliminadosProd');?>">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash2" viewBox="0 0 16 16">
            <path d="M14 3a.7.7 0 0 1-.037.225l-1.684 10.104A2 2 0 0 1 10.305 15H5.694a2 2 0 0 1-1.973-1.671L2.037 3.225A.7.7 0 0 1 2 3c0-1.105 2.686-2 6-2s6 .895 6 2M3.215 4.207l1.493 8.957a1 1 0 0 0 .986.836h4.612a1 1 0 0 0 .986-.836l1.493-8.957C11.69 4.689 9.954 5 8 5s-3.69-.311-4.785-.793"/>
        </svg> Eliminados
    </a>


    <a class="btn btn-warning float-end me-2" href="<?= base_url('Lista_Promociones');?>">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-percent" viewBox="0 0 16 16">
            <path d="M13.442 2.558a.625.625 0 0 1 0 .884l-10 10a.625.625 0 1 1-.884-.884l10-10a.625.625 0 0 1 .884 0M4.5 6a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m0 1a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5m7 6a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m0 1a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
        </svg> Promociones
    </a>


    <div class="mt-3 text">
        <h3 class="text-center Btext text-dark">Listado de Productos</h3>
        
        <table class="table table-responsive table-hover" id="users-list">
            <thead>
                <tr class="bg-success text-white">
                    <th>Nombre</th>
                    <th>Precio Costo</th>
                    <th>Precio Venta</th>
                    <th>Promoción</th> <th>Categoría</th>
                    <th>Imagen</th>
                    <th>Stock</th>
                    <th>Eliminado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if($productos): ?>
                    <?php foreach($productos as $prod): ?>
                    <tr>
                        <td><?= $prod['nombre_prod']; ?></td>
                        <td>$<?= number_format($prod['precio'], 2); ?></td>
                        <td>$<?= number_format($prod['precio_vta'], 2); ?></td>
                        
                        <td>
                            <?php if($prod['promo_activada'] == 1): 
                                $descuento = ($prod['precio_vta'] * $prod['descuento_porcentaje']) / 100;
                                $precio_final = $prod['precio_vta'] - $descuento;
                            ?>
                                <b class="text-success">$<?= number_format($precio_final, 2) ?></b><br>
                                <small class="badge bg-danger"><?= $prod['descuento_porcentaje'] ?>% OFF</small>
                            <?php else: ?>
                                <span class="text-muted">Sin promo</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <?php 
                                switch ($prod['categoria_id']) {
                                    case 1: echo 'Termos'; break;
                                    case 2: echo 'Auriculares'; break;
                                    case 3: echo 'Juguetes'; break;
                                    default: echo 'S/C'; break;
                                }
                            ?>
                        </td>
                        
                        <td>
                            <img class="frmImg" src="<?= base_url('assets/uploads/'.$prod['imagen']);?>" style="width: 50px;">
                        </td>
                        
                        <td class="text-center">
                            <?= $prod['stock']; ?> 
                            <br><small class="text-muted">Min: <?= $prod['stock_min']; ?></small>
                        </td>
                        
                        <td class="text-center"><?= $prod['eliminado']; ?></td>

                        <td>
                            <a class="btn btn-sm btn-outline-info" href="<?= base_url('ProductoEdit/'.$prod['id_producto']);?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                </svg>
                            </a>
                            <a class="btn btn-sm btn-outline-danger" href="<?= base_url('deleteProd/'.$prod['id_producto']);?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <br>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready( function () {
        $('#users-list').DataTable({
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página.",
                "zeroRecords": "Lo sentimos! No hay resultados.",
                "info": "Mostrando la página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles.",
                "infoFiltered": "(filtrado de _MAX_ registros totales)",
                "search": "Buscar: ",
                "paginate": {
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            }
        });
    });
</script>
<br><br>