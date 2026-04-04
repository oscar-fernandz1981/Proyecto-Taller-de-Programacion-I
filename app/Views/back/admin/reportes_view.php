<?php if(session("msg")):?>
   <div class="container alert alert-success text-center" style="width: 50%;">
      <?php echo session("msg"); ?>
   </div>
<?php endif?> 

<div class="container-fluid mt-5 fondo3 rounded">
  <br>
  <div class="mt-3 text">
    <h3 class="text-center Btext text-dark">Panel de Estadísticas de Venta</h3>
    
    <div class="row mt-4">
      <div class="col-12">
        <div class="card">
          <div class="card-header bg-secondary text-white">
            <h5>📊 Análisis Visual por Período</h5>
          </div>
          <div class="card-body">
            <form method="get" action="<?php echo base_url('ReportesVentas'); ?>">
              <div class="row">
                <div class="col-md-4">
                  <label>Fecha Desde:</label>
                  <input type="date" name="fecha_desde" class="form-control" value="<?php echo $fecha_desde ?? ''; ?>">
                </div>
                <div class="col-md-4">
                  <label>Fecha Hasta:</label>
                  <input type="date" name="fecha_hasta" class="form-control" value="<?php echo $fecha_hasta ?? ''; ?>">
                </div>
                <div class="col-md-4">
                  <label>&nbsp;</label><br>
                  <button type="submit" class="btn btn-success w-100">Actualizar Estadísticas</button>
                </div>
              </div>
            </form>
            
            <hr>
            
            <?php if(!empty($prod_stats) || !empty($pago_stats)): ?>
              <div class="row">
                <div class="col-md-7">
                  <div class="card shadow-sm">
                    <div class="card-body">
                      <h6 class="text-center fw-bold">Unidades Vendidas por Categoría</h6>
                      <canvas id="chartProductos" style="max-height: 400px;"></canvas>
                    </div>
                  </div>
                </div>

                <div class="col-md-5">
                  <div class="card shadow-sm">
                    <div class="card-body text-center">
                      <h6 class="fw-bold">Preferencia de Pago</h6>
                      <canvas id="chartPagos" style="max-height: 400px;"></canvas>
                    </div>
                  </div>
                </div>
              </div>
            <?php else: ?>
              <div class="text-center py-5">
                <p class="text-muted">Seleccione un rango de fechas y haga clic en "Actualizar Estadísticas" para visualizar los gráficos.</p>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Recuperamos los datos enviados desde el controlador
    const prodDataRaw = <?php echo json_encode($prod_stats ?? []); ?>;
    const pagoDataRaw = <?php echo json_encode($pago_stats ?? []); ?>;

    if (prodDataRaw.length > 0) {
        // Mapeo manual para asegurar que tus 3 categorías se vean bien
        // Nota: Asegurate que estos IDs coincidan con los de tu tabla de categorías/productos
        const nombreCategorias = { 1: 'Termos', 2: 'Juguetes', 3: 'Auriculares' };

        const ctxProd = document.getElementById('chartProductos').getContext('2d');
        new Chart(ctxProd, {
            type: 'bar',
            data: {
                labels: prodDataRaw.map(item => nombreCategorias[item.categoria_id] || 'Otras'),
                datasets: [{
                    label: 'Unidades Vendidas',
                    data: prodDataRaw.map(item => item.total_vendido),
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.7)', // Azul
                        'rgba(255, 99, 132, 0.7)', // Rojo
                        'rgba(255, 206, 86, 0.7)'  // Amarillo
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: { y: { beginAtZero: true } },
                plugins: { legend: { display: false } }
            }
        });

        const ctxPago = document.getElementById('chartPagos').getContext('2d');
        new Chart(ctxPago, {
            type: 'doughnut',
            data: {
                labels: pagoDataRaw.map(item => item.tipo_pago),
                datasets: [{
                    data: pagoDataRaw.map(item => item.cantidad),
                    backgroundColor: ['#28a745', '#ffc107', '#17a2b8'],
                    hoverOffset: 4
                }]
            }
        });
    }
</script>