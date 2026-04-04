<?php if(session("msg")):?>
   <div class="container alert alert-success text-center" style="width: 50%;">
      <?php echo session("msg"); ?>
   </div>
<?php endif?> 

<div class="container-fluid mt-5 fondo3 rounded">
  <br>
  <div class="mt-3 text">
    <h3 class="text-center Btext text-dark">Estadísticas de Ventas</h3>
    
    <div class="row mt-4">
      <!-- Productos Más Vendidos -->
      <div class="col-md-6">
        <div class="card">
          <div class="card-header bg-success text-white">
            <h5>📊 Productos Más Vendidos</h5>
          </div>
          <div class="card-body">
            <?php if($productos_mas_vendidos): ?>
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Producto</th>
                    <th>Unidades Vendidas</th>
                    <th>Total Recaudado</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($productos_mas_vendidos as $producto): ?>
                  <tr>
                    <td><?php echo $producto['nombre_prod']; ?></td>
                    <td class="text-center"><?php echo $producto['total_vendido']; ?></td>
                    <td>$<?php echo number_format($producto['total_recaudado'], 2); ?></td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            <?php else: ?>
              <p class="text-center">No hay datos de ventas</p>
            <?php endif; ?>
          </div>
        </div>
      </div>
      
      <!-- Clientes Top -->
      <div class="col-md-6">
        <div class="card">
          <div class="card-header bg-primary text-white">
            <h5>👥 Clientes con Más Compras</h5>
          </div>
          <div class="card-body">
            <?php if($clientes_top): ?>
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Cliente</th>
                    <th>Total de Compras</th>
                    <th>Monto Total</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($clientes_top as $cliente): ?>
                  <tr>
                    <td><?php echo $cliente['nombre'] . ' ' . $cliente['apellido']; ?></td>
                    <td class="text-center"><?php echo $cliente['total_compras']; ?></td>
                    <td>$<?php echo number_format($cliente['monto_total'], 2); ?></td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            <?php else: ?>
              <p class="text-center">No hay datos de clientes</p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Estadísticas Generales -->
    <div class="row mt-4">
      <div class="col-md-4">
        <div class="card text-white bg-info">
          <div class="card-body text-center">
            <h4>$<?php echo number_format($ventas_totales, 2); ?></h4>
            <p>Ventas Totales</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-white bg-warning">
          <div class="card-body text-center">
            <h4><?php echo $total_clientes; ?></h4>
            <p>Clientes Registrados</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-white bg-danger">
          <div class="card-body text-center">
            <h4><?php echo $total_productos; ?></h4>
            <p>Productos Activos</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>