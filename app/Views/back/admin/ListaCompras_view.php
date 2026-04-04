<div class="container mt-5 fondo3 rounded">
    <br>
    <div class="mt-3 text">
        <h3 class="text-center Btext text-dark">Historial de Compras</h3>

        <div class="card my-4 shadow-sm">
            <div class="card-body bg-light">
                <form method="get" action="<?= base_url('compras') ?>" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Fecha Desde:</label>
                        <input type="date" name="fecha_desde" class="form-control" value="<?= $fecha_desde ?? '' ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Fecha Hasta:</label>
                        <input type="date" name="fecha_hasta" class="form-control" value="<?= $fecha_hasta ?? '' ?>">
                    </div>
                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-success w-100">Filtrar</button>
                        <a href="<?= base_url('compras') ?>" class="btn btn-secondary w-100">Limpiar</a>
                    </div>
                </form>
            </div>
        </div>

        <table class="table table-responsive table-hover" id="users-list">
            <thead>
                <tr class="bg-success">
                    <th>ID Compra</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Tipo Pago</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if($ventas): ?>
                    <?php 
                        $session = session();
                        $perfil = $session->get('perfil_id'); 
                    ?>
                    <?php foreach($ventas as $vta): ?>
                    <tr>
                        <td><?php echo $vta['id']; ?></td>
                        <td><?php echo $vta['nombre']; ?></td>
                        <td><?php echo $vta['apellido']; ?></td>
                        <td class="text-center"><?php echo $vta['fecha']; ?></td>
                        <td class="text-center">$<?php echo number_format($vta['total_venta'], 2, ',', '.'); ?></td>
                        <td><?php echo $vta['tipo_pago']; ?></td>
                        <td>
                            <div class="d-flex gap-2">
                                <a class="btn btn-outline-primary btn-sm" href="<?php echo base_url('DetalleVta/'.$vta['id']);?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-checklist" viewBox="0 0 16 16">
                                        <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                                        <path d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0zM7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z"/>
                                    </svg> Detalle
                                </a>

                                <?php if ($perfil == 2): ?>
                                    <a class="btn btn-outline-success btn-sm" href="<?= base_url('factura_cliente/'.$vta['id']); ?>" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
                                            <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                                            <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
                                        </svg> PDF
                                    </a>
                                <?php endif; ?>
                            </div>
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