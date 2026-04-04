<br>
<div class="container mt-1 mb-0">
  <div class="card fondo2 container" style="width: 50%;" >
    <div class= "card-header text-center">
      <h2>Registrar Nuevo Producto</h2>
    </div>
  
 <?php $validation = \Config\Services::validation(); ?>
     <form method="post" enctype="multipart/form-data" action="<?php echo base_url('ProductoValidation') ?>">
      <?=csrf_field();?>
      <?php if(!empty (session()->getFlashdata('fail'))):?>
      <div class="alert alert-danger"><?=session()->getFlashdata('fail');?></div>
 <?php endif?>
           <?php if(!empty (session()->getFlashdata('success'))):?>
      <div class="alert alert-danger"><?=session()->getFlashdata('success');?></div>
  <?php endif?>     
<div class ="card-body" media="(max-width:768px)">
  <div class="mb-2">
   <label for="exampleFormControlInput1" class="form-label">Nombre</label>
   <input name="nombre" type="text"  class="form-control" placeholder="nombre" >
     <!-- Error -->
        <?php if($validation->getError('nombre')) {?>
            <div class='alert alert-danger mt-2'>
              <?= $error = $validation->getError('nombre'); ?>
            </div>
        <?php }?>
  </div>
  <div class="mb-3">
   <label for="exampleFormControlTextarea1" class="form-label">Descripción</label>
    <input type="text" name="descripcion"class="form-control" placeholder="Descripcion" >
    <!-- Error -->
        <?php if($validation->getError('descripcion')) {?>
            <div class='alert alert-danger mt-2'>
              <?= $error = $validation->getError('descripcion'); ?>
            </div>
        <?php }?>
    </div>
  <div class="mb-2">
  <label for="exampleFormControlInput1" class="form-label">Imagen</label>
  <input name="imagen" type="file"  class="form-control">
  <?php if($validation->getError('imagen')) {?>
            <div class='alert alert-danger mt-2'>
              <?= $error = $validation->getError('imagen'); ?>
            </div>
        <?php }?>
  </div>
  <br>
  <div class="mb-3">
   <label for="exampleFormControlTextarea1" class="form-label">Categoria</label>
    <select name="categoria_id">
    <option>Seleccione Categoria</option>
    <option value="1">Termos</option>
    <option value="2">Auriculares</option>
    <option value="3">Juguetes</option>
    
    </select>
    <!-- Error -->
        <?php if($validation->getError('categoria_id')) {?>
            <div class='alert alert-danger mt-2'>
              <?= $error = $validation->getError('categoria_id'); ?>
            </div>
        <?php }?>
    </div>
    <div class="mb-3">
       <label for="exampleFormControlInput1" class="form-label">Precio</label>
   <input name="precio"  type="text" class="form-control"  placeholder="precio" >
    <!-- Error -->
        <?php if($validation->getError('precio')) {?>
            <div class='alert alert-danger mt-2'>
              <?= $error = $validation->getError('precio'); ?>
            </div>
        <?php }?>
  </div>
    <div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Precio Venta</label>
   <input  type="text" name="precio_vta" class="form-control" placeholder="Precio de Venta">
   <!-- Error -->
        <?php if($validation->getError('precio_vta')) {?>
            <div class='alert alert-danger mt-2'>
              <?= $error = $validation->getError('precio_vta'); ?>
            </div>
        <?php }?>
  </div>
  
  <div class="mb-3">
   <label for="exampleFormControlInput1" class="form-label">Stock</label>
   <input name="stock" type="text" class="form-control"  placeholder="Stock">
   <!-- Error -->
        <?php if($validation->getError('stock')) {?>
            <div class='alert alert-danger mt-2'>
              <?= $error = $validation->getError('stock'); ?>
            </div>
        <?php }?>
  </div>

  <div class="mb-3">
   <label for="exampleFormControlInput1" class="form-label">Stock Minimo</label>
   <input name="stock_min" type="text" class="form-control"  placeholder="Stock Minimo">
   <!-- Error -->
        <?php if($validation->getError('stock_min')) {?>
            <div class='alert alert-danger mt-2'>
              <?= $error = $validation->getError('stock_min'); ?>
            </div>
        <?php }?>
  </div>



  <div class="row border rounded p-3 mb-3 bg-light">
    <div class="col-md-6 mb-3">
        <label class="form-label fw-bold">¿Activar Promoción?</label>
        <select name="promo_activada" class="form-select" id="promo_select">
            <option value="0" selected>No</option>
            <option value="1">Sí</option>
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label fw-bold">Porcentaje de Descuento</label>
        <div class="input-group">
            <input name="descuento_porcentaje" id="desc_input" type="number" 
                   class="form-control" placeholder="0" 
                   min="0" max="100" value="0">
            <span class="input-group-text">%</span>
        </div>
    </div>
</div>

<script>
    const promoSelect = document.getElementById('promo_select');
    const descInput = document.getElementById('desc_input');

    // Bloquea el campo de porcentaje si no hay promo activa
    promoSelect.addEventListener('change', function() {
        if (this.value === "0") {
            descInput.value = 0;
            descInput.disabled = true;
        } else {
            descInput.disabled = false;
        }
    });
    
    // Estado inicial
    descInput.disabled = true;
</script>



  <br>
          <input type="submit" value="Guardar" class="btn btn-outline-success float-end ms-2">
          <a type="reset" href="<?php echo base_url('Lista_Productos');?>" class="btn btn-outline-danger float-end">Cancelar</a>
      <br><br>
 </div>
</form>
</div>
</div>
<br>