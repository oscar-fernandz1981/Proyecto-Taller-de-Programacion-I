<?php 
$session = session();
$nombre = $session->get('nombre');
$email = $session->get('email');
?>

<div class="container mt-5 mb-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card fondo2">
        <div class="card-header text-center">
          <h3 class="mb-0 text-black">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-chat-left-text" viewBox="0 0 16 16">
              <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
              <path d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6zm0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
            </svg>
            Formulario de Consulta
          </h3>
        </div>
        
        <div class="card-body">
          <?php if(session()->getFlashdata('msg')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <?= session()->getFlashdata('msg') ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php endif; ?>
          
          <p class="text-black">Complete el siguiente formulario para enviarnos su consulta. Le responderemos a la brevedad.</p>
          
          <form method="post" action="<?php echo base_url('submit-form') ?>">
            <?= csrf_field() ?>
            
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label text-black">Nombre</label>
                <?php if($nombre != null): ?>
                  <input type="text" name="nombre" value="<?php echo $nombre ?>" readonly class="form-control bg-light">
                  <?php else: ?>
                  <input type="text" name="nombre" class="form-control" placeholder="Ingrese su nombre" value="<?= old('nombre') ?>" >
                  <?php if (session('validation') && session('validation')->hasError('nombre')): ?>
                    <div class="text-danger small mt-1">
                      <?= session('validation')->getError('nombre') ?>
                    </div>
                  <?php endif; ?>
                <?php endif; ?>
              </div>
              
              <div class="col-md-6 mb-3">
                <label class="form-label text-black">Email</label>
                <?php if($email != null): ?>
                  <input type="email" name="email" value="<?php echo $email ?>" readonly class="form-control bg-light">
                <?php else: ?>
                  <input type="email" name="email" class="form-control" placeholder="ejemplo@email.com" value="<?= old('email') ?>" >
                  <?php if (session('validation') && session('validation')->hasError('email')): ?>
                    <div class="text-danger small mt-1">
                      <?= session('validation')->getError('email') ?>
                    </div>
                  <?php endif; ?>
                <?php endif; ?>
              </div>
            </div>
            
            <div class="mb-3">
              <label class="form-label text-black">Asunto</label>
              <select name="asunto" class="form-select">
                <option value="">Seleccione el motivo de su consulta</option>
                <option value="Información de productos" <?= old('asunto') == 'Información de productos' ? 'selected' : '' ?>>Información de productos</option>
                <option value="Problema con pedido" <?= old('asunto') == 'Problema con pedido' ? 'selected' : '' ?>>Problema con pedido</option>
                <option value="Devolución o cambio" <?= old('asunto') == 'Devolución o cambio' ? 'selected' : '' ?>>Devolución o cambio</option>
                <option value="Estado de envío" <?= old('asunto') == 'Estado de envío' ? 'selected' : '' ?>>Estado de envío</option>
                <option value="Facturación" <?= old('asunto') == 'Facturación' ? 'selected' : '' ?>>Facturación</option>
                <option value="Otro" <?= old('asunto') == 'Otro' ? 'selected' : '' ?>>Otro</option>
              </select>

              <?php if (session('validation') && session('validation')->hasError('asunto')): ?>
                  <div class="text-danger small mt-1">
                      <?= session('validation')->getError('asunto') ?>
                  </div>
              <?php endif; ?>
            </div>
            
            <div class="mb-3">
              <label class="form-label text-black">Mensaje</label>
              <textarea class="form-control" name="mensaje" rows="6" placeholder="Escriba su consulta aquí..."><?= old('mensaje') ?></textarea>
              <?php if (session('validation') && session('validation')->hasError('mensaje')): ?>
                <div class="text-danger small mt-1">
                  <?= session('validation')->getError('mensaje') ?>
                </div>
              <?php endif; ?>
            </div>
            
            <div class="d-flex justify-content-between mt-4">
              <?php if (session()->get('id_usuario')): ?>
                  <a href="<?php echo base_url('panel'); ?>" class="btn btn-primary">
                      Volver al Panel
                  </a>
              <?php else: ?>
                  <a href="<?php echo base_url('/'); ?>" class="btn btn-secondary">
                      Inicio
                  </a>
              <?php endif; ?>

              <button type="submit" class="btn btn-success">
                  Enviar Consulta
              </button>
            </div>
          </form>
        </div>
        
        <div class="card-footer text-center text-black">
          <small>
            <strong>Horario de atención:</strong> Lunes a Viernes de 9:00 a 21:00 hs<br>
            <strong>Email:</strong> contacto@blass.com.ar
          </small>
        </div>
      </div>
    </div>
  </div>
</div>