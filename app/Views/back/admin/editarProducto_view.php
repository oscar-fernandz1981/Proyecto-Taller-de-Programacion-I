<br>
<div class="container mt-1 mb-0">
  <div class="card fondo2 text-dark container" >
    <div class= "card-header text-center">
      <h2>Editar Producto</h2>
    </div>
 <?php $validation = \Config\Services::validation(); ?>
     <form method="post" enctype="multipart/form-data" action="<?php echo base_url('/enviarEdicionProd') ?>">
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
   <input name="nombre" type="text"  class="form-control" placeholder="nombre" 
   value="<?php echo $data['nombre_prod']?>">
     <!-- Error -->
        <?php if($validation->getError('nombre_prod')) {?>
            <div class='alert alert-danger mt-2'>
              <?= $error = $validation->getError('nombre_prod'); ?>
            </div>
        <?php }?>
  </div>

 
    <label for="exampleFormControlInput1" class="form-label">Imagen Actual: </label>
    <div class="mb-3">
      <img class="frmImg2 rounded" src="<?php echo base_url('assets/uploads/'.$data['imagen']);?>">
      <br><br>
       <input name="imagen"  type="file" class="form-control">
    <!-- Error -->
        <?php if($validation->getError('imagen')) {?>
            <div class='alert alert-danger mt-2'>
              <?= $error = $validation->getError('imagen'); ?>
            </div>
        <?php }?>
  </div>
    <div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Precio</label>
   <input  type="text" name="precio" class="form-control" value="<?php echo $data['precio']?>">
   <!-- Error -->
        <?php if($validation->getError('precio')) {?>
            <div class='alert alert-danger mt-2'>
              <?= $error = $validation->getError('precio'); ?>
            </div>
        <?php }?>
  </div>
  
  <div class="mb-3">
   <label for="exampleFormControlInput1" class="form-label">Precio Venta</label>
   <input name="precio_vta" type="text" class="form-control" value="<?php echo $data['precio_vta']?>">
   <!-- Error -->
        <?php if($validation->getError('precio_vta')) {?>
            <div class='alert alert-danger mt-2'>
              <?= $error = $validation->getError('precio_vta'); ?>
            </div>
        <?php }?>
  </div>

  <div class="mb-3">
   <label for="exampleFormControlInput1" class="form-label">Stock</label>
   <input name="stock" type="text" class="form-control" value="<?php echo $data['stock']?>">
   <!-- Error -->
        <?php if($validation->getError('stock')) {?>
            <div class='alert alert-danger mt-2'>
              <?= $error = $validation->getError('stock'); ?>
            </div>
        <?php }?>
  </div>

  <div class="mb-3">
   <label for="exampleFormControlInput1" class="form-label">Stock Minimo</label>
   <input name="stock_min" type="text" class="form-control" value="<?php echo $data['stock_min']?>">
   <!-- Error -->
        <?php if($validation->getError('stock_min')) {?>
            <div class='alert alert-danger mt-2'>
              <?= $error = $validation->getError('stock_min'); ?>
            </div>
        <?php }?>
  </div>
<br>
  <div class="mb-3">
<?php  
  $categoria='';
  switch ($data['categoria_id']) {
    case 1:
        $categoria = 'Termos';
        break;
    case 2:
        $categoria = 'Auriculares';
        break;
    case 3:
        $categoria = 'Juguetes';
        break;
   
}?>
   <label for="exampleFormControlInput1" class="form-label">Categoria</label>
   <select name="categoria_id">
    <option value="<?php echo $data['categoria_id']?>"><?php echo $categoria ?></option>
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
<br>
  <div class="mb-3">
   <label for="exampleFormControlInput1" class="form-label">Eliminado</label>
   <input name="eliminado" type="text" readonly="true" class="form-control" value="<?php echo $data['eliminado']?>">
   <!-- Error -->
        <?php if($validation->getError('eliminado')) {?>
            <div class='alert alert-danger mt-2'>
              <?= $error = $validation->getError('eliminado'); ?>
            </div>
        <?php }?>
  </div>

  <input type="hidden" name="id_producto" value="<?php echo $data['id_producto']?>">

  <br>
           <input type="submit" value="Editar" class="btn btn-outline-success float-end ms-2">
            <a type="reset" href="<?php echo base_url('Lista_Productos');?>" class="btn btn-outline-danger float-end">Cancelar</a>
      <br><br>
 </div>
</form>
</div>
</div>
<br>