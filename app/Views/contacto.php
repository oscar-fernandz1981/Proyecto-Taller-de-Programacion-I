<?php 
$session = session();
$nombre = $session->get('nombre');
$email = $session->get('email');
$id = $session->get('id');
?>

<body>
  <div class="container mt-5 fondo2 text-dark" style="width: 50%;">
    <h2 class="text-center">Contactanos</h2>
          
    <form method="post" action="<?php echo base_url('/submit-form') ?>">
      <?= csrf_field(); ?>

      <div class="form-group mb-3">
        <label>Nombre</label>
        <?php if($nombre != null){ ?>
            <input type="text" name="nombre" value="<?php echo $nombre ?>" readonly="true" class="form-control">
        <?php } else { ?>
            <input type="text" name="nombre" value="<?= old('nombre') ?>" class="form-control">
        <?php } ?>
        
        <div class="text-danger small mt-1">
            <?= validation_show_error('nombre') ?>
        </div>
      </div>
        
      <div class="form-group mb-3">
        <label>E-mail</label>
        <?php if($email != null){ ?>
            <input type="text" name="email" value="<?php echo $email ?>" readonly="true" class="form-control">
        <?php } else { ?>
            <input type="text" name="email" value="<?= old('email') ?>" class="form-control">
        <?php } ?>
        
        <div class="text-danger small mt-1">
            <?= validation_show_error('email') ?>
        </div>
      </div>
      
      <div class="form-group mb-3">
        <label for="mensaje">Mensaje</label>
        <textarea class="form-control" name="mensaje" rows="3"><?= old('mensaje') ?></textarea>
        
        <div class="text-danger small mt-1">
            <?= validation_show_error('mensaje') ?>
        </div>
      </div>

      <br>
      <div class="clearfix">
        <button type="submit" class="btn btn-outline-success float-end ms-2">Enviar</button>
        <a href="<?= base_url('contacto') ?>" class="btn btn-outline-danger float-end">Cancelar</a>
      </div>
      <br>
    </form>
  </div>
<br>