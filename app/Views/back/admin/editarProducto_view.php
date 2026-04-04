<br>
<div class="container mt-1 mb-0">
  <div class="card fondo2 text-dark container">
    <div class="card-header text-center">
      <h2>Editar Producto</h2>
    </div>

    <?php $validation = \Config\Services::validation(); ?>

    <form method="post" enctype="multipart/form-data" action="<?= base_url('/enviarEdicionProd') ?>">
      <?= csrf_field(); ?>

      <div class="card-body">
        
        <div class="mb-2">
          <label class="form-label">Nombre</label>
          <input name="nombre" type="text" class="form-control" 
                 value="<?= old('nombre') !== null ? old('nombre') : $data['nombre_prod'] ?>">
          <?php if($validation->getError('nombre')) { ?>
            <div class='alert alert-danger mt-2'><?= $validation->getError('nombre'); ?></div>
          <?php } ?>
        </div>

        <div class="mb-3">
          <label class="form-label">Imagen Actual:</label><br>
          <img class="frmImg2 rounded" src="<?= base_url('assets/uploads/'.$data['imagen']); ?>" style="width: 150px;">
          <input name="imagen" type="file" class="form-control mt-2">
          <?php if($validation->getError('imagen')) { ?>
            <div class='alert alert-danger mt-2'><?= $validation->getError('imagen'); ?></div>
          <?php } ?>
        </div>

        <div class="mb-3">
          <label class="form-label">Precio</label>
          <input type="text" name="precio" class="form-control" 
                 value="<?= old('precio') !== null ? old('precio') : $data['precio'] ?>">
          <?php if($validation->getError('precio')) { ?>
            <div class='alert alert-danger mt-2'><?= $validation->getError('precio'); ?></div>
          <?php } ?>
        </div>

        <div class="mb-3">
          <label class="form-label">Precio Venta</label>
          <input name="precio_vta" type="text" class="form-control" 
                 value="<?= old('precio_vta') !== null ? old('precio_vta') : $data['precio_vta'] ?>">
          <?php if($validation->getError('precio_vta')) { ?>
            <div class='alert alert-danger mt-2'><?= $validation->getError('precio_vta'); ?></div>
          <?php } ?>
        </div>

        <div class="mb-3">
          <label class="form-label">Stock</label>
          <input name="stock" type="number" min="0" class="form-control" 
                 value="<?= old('stock') !== null ? old('stock') : $data['stock'] ?>">
          <?php if($validation->getError('stock')) { ?>
            <div class='alert alert-danger mt-2'><?= $validation->getError('stock'); ?></div>
          <?php } ?>
        </div>

        <div class="mb-3">
          <label class="form-label">Stock Mínimo</label>
          <input name="stock_min" type="number" min="1" class="form-control" 
                 value="<?= old('stock_min') !== null ? old('stock_min') : $data['stock_min'] ?>">
          <?php if($validation->getError('stock_min')) { ?>
            <div class='alert alert-danger mt-2'><?= $validation->getError('stock_min'); ?></div>
          <?php } ?>
        </div>

        <div class="mb-3">
          <label class="form-label">Categoría</label>
          <?php 
            $seleccionada = old('categoria_id') ?: $data['categoria_id']; 
          ?>
          <select name="categoria_id" class="form-select">
            <option value="1" <?= $seleccionada == 1 ? 'selected' : '' ?>>Termos</option>
            <option value="2" <?= $seleccionada == 2 ? 'selected' : '' ?>>Auriculares</option>
            <option value="3" <?= $seleccionada == 3 ? 'selected' : '' ?>>Juguetes</option>
          </select>
          <?php if($validation->getError('categoria_id')) { ?>
            <div class='alert alert-danger mt-2'><?= $validation->getError('categoria_id'); ?></div>
          <?php } ?>
        </div>


        <hr>
        <h5 class="text-center bg-light p-2 rounded">Configuración de Oferta</h5>
        
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">¿Activar Promo?</label>
                <?php $promo_status = old('promo_activada') !== null ? old('promo_activada') : $data['promo_activada']; ?>
                <select name="promo_activada" class="form-select border-warning">
                    <option value="0" <?= $promo_status == 0 ? 'selected' : '' ?>>No (Precio Normal)</option>
                    <option value="1" <?= $promo_status == 1 ? 'selected' : '' ?>>Si (Aplicar Descuento)</option>
                </select>
                <?php if($validation->getError('promo_activada')) { ?>
                    <div class='alert alert-danger mt-2'><?= $validation->getError('promo_activada'); ?></div>
                <?php } ?>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Porcentaje de Descuento (%)</label>
                <input name="descuento_porcentaje" type="number" min="0" max="100" class="form-control border-warning" 
                       placeholder="Ej: 15"
                       value="<?= old('descuento_porcentaje') !== null ? old('descuento_porcentaje') : $data['descuento_porcentaje'] ?>">
                <?php if($validation->getError('descuento_porcentaje')) { ?>
                    <div class='alert alert-danger mt-2'><?= $validation->getError('descuento_porcentaje'); ?></div>
                <?php } ?>
            </div>
        </div>

        <input type="hidden" name="id_producto" value="<?= $data['id_producto'] ?>">

        <div class="mt-4">
          <input type="submit" value="Editar" class="btn btn-outline-success float-end ms-2">
          <a href="<?= base_url('Lista_Productos'); ?>" class="btn btn-outline-danger float-end">Cancelar</a>
        </div>
        <br><br>
      </div>
    </form>
  </div>
</div>
<br>