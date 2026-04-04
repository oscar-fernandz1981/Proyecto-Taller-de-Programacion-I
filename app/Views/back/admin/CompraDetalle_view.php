<div class="container mt-5 fondo3 rounded">
  <br>
  <?php $session = session();
          $perfil=$session->get('perfil_id');
          $id=$session->get('id');
          ?>
  <?php if($perfil==1){?>
<!--<a class="btn btn-primary float-end" href="<?php echo base_url('compras');?>">
  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-back" viewBox="0 0 16 16">
  <path d="M0 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v2h2a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-2H2a2 2 0 0 1-2-2V2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H2z"/>
  </svg>Volver</a>
  -->

<a class="btn btn-primary float-end" href="<?php echo base_url('compras');?>" tabindex="-1" aria-disabled="true">
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-backspace" viewBox="0 0 16 16">
<path d="M5.83 5.146a.5.5 0 0 0 0 .708L7.975 8l-2.147 2.146a.5.5 0 0 0 .707.708l2.147-2.147 2.146 2.147a.5.5 0 0 0 .707-.708L9.39 8l2.146-2.146a.5.5 0 0 0-.707-.708L8.683 7.293 6.536 5.146a.5.5 0 0 0-.707 0z"/>
<path d="M13.683 1a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-7.08a2 2 0 0 1-1.519-.698L.241 8.65a1 1 0 0 1 0-1.302L5.084 1.7A2 2 0 0 1 6.603 1zm-7.08 1a1 1 0 0 0-.76.35L1 8l4.844 5.65a1 1 0 0 0 .759.35h7.08a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1z"/>
</svg> Volver</a>



<?php }else{?>
   <!-- <a class="btn btn-primary float-end" href="<?php echo base_url('misCompras/'.$id);?>">
  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-back" viewBox="0 0 16 16">
  <path d="M0 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v2h2a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-2H2a2 2 0 0 1-2-2V2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H2z"/>
  </svg>Volver</a>-->
<?php }?>
  <div class="mt-3 text">
  <h3 class="text-center Btext text-dark">Detalle de la Compra</h3>
  <br><br>
  <table class="table table-responsive table-hover" id="users-list">
       <thead>
          <tr class="bg-success">
             <th>ID Producto</th>
             <th >Nombre</th>
             <th class="text-center">Cantidad Comprada</th>
             <th class="text-center">Precio Unitario</th>
             <th class="text-center">Total</th>
          </tr>
       </thead>
       <tbody>
          <?php if($ventas): ?>
          <?php foreach($ventas as $vta): ?>
          <tr>
             <td class="bg-light"><?php echo $vta['id_producto']; ?></td>
             <td class="bg-light"><?php echo $vta['nombre_prod']; ?></td>
             <td class="text-center bg-light"><?php echo $vta['cantidad']; ?></td>
             <td class="text-center bg-light"><?php echo $vta['precio']; ?></td>
             <td class="text-center bg-light"><?php echo $vta['total']; ?></td>
            </tr>
         <?php endforeach; ?>
         <?php endif; ?>
         
     </table>
     <br>
  </div>
</div>

<br><br>