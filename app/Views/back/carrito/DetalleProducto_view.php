<?php $session = session();
          $nombre= $session->get('nombre');
          $perfil=$session->get('perfil_id');
          $id=$session->get('id');?>

<div class="container mt-1 mb-0 fondo2 text-dark">
<div class= "card-header text-center">
      <h2 class="Btext">Detalles del Producto</h2>
    </div>
 <?php $validation = \Config\Services::validation(); ?>
     <form method="post" enctype="multipart/form-data" action="<?php echo base_url('Carrito_agrega') ?>" class="text-dark">
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
   <input name="nombre" type="text" readonly="true"  class="form-control" placeholder="nombre" 
   value="<?php echo $data['nombre_prod']?>">
     <!-- Error -->
        <?php if($validation->getError('nombre_pro')) {?>
            <div class='alert alert-danger mt-2'>
              <?= $error = $validation->getError('nombre_prod'); ?>
            </div>
        <?php }?>
  </div>
  
    <label for="exampleFormControlInput1" class="form-label">Imagen Del Producto: </label>
    <div class="mb-3">
      <img class="frmImg4 rounded" src="<?php echo base_url('assets/uploads/'.$data['imagen']);?>">
      <br><br>
    <!-- Error -->
        <?php if($validation->getError('imagen')) {?>
            <div class='alert alert-danger mt-2'>
              <?= $error = $validation->getError('imagen'); ?>
            </div>
        <?php }?>
  </div>
<div class="mb-3">
    <label class="form-label">Precio en ARS$</label>
    
    <?php if ($data['promo_activada'] == 1): ?>
        <?php 
            $descuento = ($data['precio_vta'] * $data['descuento_porcentaje']) / 100;
            $precio_final = $data['precio_vta'] - $descuento;
        ?>
        <div class="input-group">
            <span class="input-group-text text-decoration-line-through text-danger">
                $<?= number_format($data['precio_vta'], 2, ',', '.'); ?>
            </span>
            <input type="text" readonly="true" class="form-control fw-bold text-success" 
                   style="font-size: 1.2rem;"
                   value="$<?= number_format($precio_final, 2, ',', '.'); ?>">
            <span class="badge bg-warning text-dark d-flex align-items-center">
                <?= $data['descuento_porcentaje']; ?>% OFF
            </span>
        </div>
        
        <input type="hidden" name="precio_vta_final" value="<?= $precio_final; ?>">

    <?php else: ?>
        <input name="precio_vta" type="text" readonly="true" class="form-control" 
               value="$<?= number_format($data['precio_vta'], 2, ',', '.'); ?>">
    <?php endif; ?>
</div>

  <div class="mb-3">
   <label for="exampleFormControlInput1" class="form-label">Stock</label>
   <input name="stock" type="text" readonly="true" class="form-control" value="<?php echo $data['stock']?>">
   <!-- Error -->
        <?php if($validation->getError('stock')) {?>
            <div class='alert alert-danger mt-2'>
              <?= $error = $validation->getError('stock'); ?>
            </div>
        <?php }?>
  </div>

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
<br>
   <label for="exampleFormControlInput1" class="form-label">Categoria</label>
   <input name="categoria_id" type="text" readonly="true" class="form-control" value="<?php echo $categoria ?>">
   <!-- Error -->
        <?php if($validation->getError('categoria_id')) {?>
            <div class='alert alert-danger mt-2'>
              <?= $error = $validation->getError('categoria_id'); ?>
            </div>
        <?php }?>
  </div>

  <input type="hidden" name="id_producto" value="<?php echo $data['id_producto']?>">

  <br>      

  <?php
                                     if($data['stock'] <= 0){
                                         $btn = array(
                                         'class' => 'btn btn-danger float-end',
                                              'value' => 'Comprar',
                                             'disabled' => '',
                                             'name' => 'action'
                                             );
                                      echo form_submit($btn);
                                       echo form_close();

                                           ?>
                                          <?php
                                      } else if ($session){
                                        if ($perfil==2) {
                                           // Envia los datos en forma de formulario para agregar al carrito
                                   echo form_open('Carrito_agrega');
                                         echo form_hidden('id_producto', $data['id_producto']);
                                         echo form_hidden('nombre_prod', $data['nombre_prod']);
                                         echo form_hidden('precio_vta', $data['precio_vta']);
                                         echo form_hidden('stock', $data['stock']);
                                                       ?>
                                                      <?php
                                                                        $btn = array(
                                                                         'onclick'=> 'comprar()',
                                                 'class' => 'btn btn-outline-success float-end',
                                                   'value' => 'Comprar',
                                                   'name' => 'action'
                                                           );
                                            echo form_submit($btn);
                                           echo form_close();
   
   
                                           }else{
                                           ?>
                                           <input id="btnAdvertencia" type="button" onclick="alert('¡Debe registrarse o Logearse para Comprar!')" value="Desea Comprar?" />
                                           <?php  }
                                           ?>
                                           <?php
                                           } else {
                                           ?>
                                           <button class=" btn btn-success" type="submit">
                                           <a type="button" class="btn btn-outline-success" href="<?php echo base_url('login');?>">Comprar</a>
                                           </button>
   
                                           <?php
   
                                           }
                                           ?>
            
           
           <?php
                // Decidimos la ruta de retorno
                $url_regreso = ($fuente == 'promo') ? base_url('promociones') : base_url('catalogo');
                $texto_boton = ($fuente == 'promo') ? 'Volver a Ofertas' : 'Volver al Catálogo';
            ?>

            <a href="<?= $url_regreso; ?>" class="btn btn-outline-secondary float-end">
                 <?= $texto_boton; ?>
            </a>
      
           <br><br>
 </div>
</form>
</div>