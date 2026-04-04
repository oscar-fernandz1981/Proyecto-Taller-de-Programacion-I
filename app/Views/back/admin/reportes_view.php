<?php if(session("msg")):?>
   <div class="container alert alert-success text-center" style="width: 50%;">
      <?php echo session("msg"); ?>
   </div>
<?php endif?> 

<div class="container-fluid mt-5 fondo3 rounded">
  <br>
  <div class="mt-3 text">
    <h3 class="text-center Btext text-dark">Reportes Detallados</h3>
    
    <div class="row mt-4">
      <div class="col-12">
        <div class="card">
          <div class="card-header bg-secondary text-white">
            <h5>📈 Reporte de Ventas por Período</h5>
          </div>
          <div class="card-body">
            <!-- Aquí puedes agregar filtros por fecha -->
            <form method="get" action="<?php echo base_url('ReportesVentas'); ?>">
              
              <div class="row">
                <div class="col-md-4">
                  <label>Fecha Desde:</label>
                  <input type="date" name="fecha_desde" class="form-control">
                </div>
                <div class="col-md-4">
                  <label>Fecha Hasta:</label>
                  <input type="date" name="fecha_hasta" class="form-control">
                </div>
                <div class="col-md-4">
                  <label>&nbsp;</label><br>
                  <button type="submit" class="btn btn-success">Generar Reporte</button>
                </div>
              </div>
            </form>
            
            <hr>
            
            <?php if($ventas_periodo): ?>
              <table class="table table-striped" id="reporte-table">
                <thead>
                  <tr>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unit.</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($ventas_periodo as $venta): ?>
                  <tr>
                    <td><?php echo $venta['fecha']; ?></td>
                    <td><?php echo $venta['cliente_nombre']; ?></td>
                    <td><?php echo $venta['producto_nombre']; ?></td>
                    <td class="text-center"><?php echo $venta['cantidad']; ?></td>
                    <td>$<?php echo number_format($venta['precio'], 2); ?></td>
                    <td>$<?php echo number_format($venta['total'], 2); ?></td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            <?php else: ?>
              <p class="text-center">No hay ventas en el período seleccionado</p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- DataTables para el reporte -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script>
  $(document).ready(function() {
    $('#reporte-table').DataTable({
      "language": {
        "lengthMenu": "Mostrar _MENU_ registros por página",
        "zeroRecords": "No se encontraron resultados",
        "info": "Mostrando página _PAGE_ de _PAGES_",
        "infoEmpty": "No hay registros disponibles",
        "search": "Buscar:",
        "paginate": {
          "next": "Siguiente",
          "previous": "Anterior"
        }
      }
    });
  });
</script>