
<?php $session = session();
          $nombre= $session->get('nombre');
          $email=$session->get('email');
          $id=$session->get('id');?>
<body>
  <div class="container mt-5 fondo2 text-dark" width=50%;>
    <h2 class="text-center">Contactanos</h2>
         
    <?php $validation = \Config\Services::validation(); ?>
    <form method="post" action="<?php echo base_url('/submit-form') ?>">
      <div class="form-group">
        <label>Nombre</label>
        <?php if($nombre != null){?>
        <input type="text" name="nombre" value="<?php echo $nombre ?>" readonly="true" class="form-control">
        <?php }else{?>
        <input type="text" name="nombre" class="form-control">
        <?php }?>
        <!-- Error -->
        <?php if($validation->getError('nombre')) {?>
            <div class='alert alert-danger mt-2'>
              <?= $error = $validation->getError('nombre'); ?>
            </div>
        <?php }?>
      </div>
       
      <div class="form-group">
        <label>E-mail</label>
        <?php if($email != null){?>
        <input type="text" name="email" value="<?php echo $email ?>" readonly="true" class="form-control">
        <?php }else{?>
        <input type="text" name="email" class="form-control">
        <?php }?>
        <!-- Error -->
        <?php if($validation->getError('email')) {?>
            <div class='alert alert-danger mt-2'>
              <?= $error = $validation->getError('email'); ?>
            </div>
        <?php }?>
      </div>
      
      <div class="form-group">
        <label for="exampleFormControlTextarea1">Mensaje</label>
        <textarea class="form-control" name="mensaje" rows="3"></textarea>
        <!-- Error -->
        <?php if($validation->getError('mensaje')) {?>
            <div class='alert alert-danger mt-2'>
              <?= $error = $validation->getError('mensaje'); ?>
            </div>
        <?php }?>
      </div>
      <br>
      <div class="">
        <button type="submit" class="btn btn-outline-success float-end">Enviar</button>
        <input type="reset" value="Cancelar" class="btn btn-outline-danger float-end">
        <br>
      </div>
      <br>
    </form>
  </div>
<br>

