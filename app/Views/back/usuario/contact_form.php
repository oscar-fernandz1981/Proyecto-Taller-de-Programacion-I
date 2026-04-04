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
          
          <?php $validation = \Config\Services::validation(); ?>
          
          <form method="post" action="<?php echo base_url('submit-form') ?>">
            <?= csrf_field() ?>
            
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label text-black">Nombre</label>
                <?php if($nombre != null): ?>
                  <input type="text" name="nombre" value="<?php echo $nombre ?>" readonly class="form-control bg-light">
                <?php else: ?>
                  <input type="text" name="nombre" class="form-control" placeholder="Ingrese su nombre" value="<?= old('nombre') ?>" required>
                  <?php if($validation->getError('nombre')): ?>
                    <div class="text-danger small mt-1">
                      <?= $validation->getError('nombre') ?>
                    </div>
                  <?php endif; ?>
                <?php endif; ?>
              </div>
              
              <div class="col-md-6 mb-3">
                <label class="form-label text-black">Email</label>
                <?php if($email != null): ?>
                  <input type="email" name="email" value="<?php echo $email ?>" readonly class="form-control bg-light">
                <?php else: ?>
                  <input type="email" name="email" class="form-control" placeholder="ejemplo@email.com" value="<?= old('email') ?>" required>
                  <?php if($validation->getError('email')): ?>
                    <div class="text-danger small mt-1">
                      <?= $validation->getError('email') ?>
                    </div>
                  <?php endif; ?>
                <?php endif; ?>
              </div>
            </div>
            
            <div class="mb-3">
              <label class="form-label text-black">Asunto</label>
              <select name="asunto" class="form-select" required>
                <option value="">Seleccione el motivo de su consulta</option>
                <option value="Información de productos">Información de productos</option>
                <option value="Problema con pedido">Problema con pedido</option>
                <option value="Devolución o cambio">Devolución o cambio</option>
                <option value="Estado de envío">Estado de envío</option>
                <option value="Facturación">Facturación</option>
                <option value="Otro">Otro</option>
              </select>
            </div>
            
            <div class="mb-3">
              <label class="form-label text-black">Mensaje</label>
              <textarea class="form-control" name="mensaje" rows="6" placeholder="Escriba su consulta aquí..." required><?= old('mensaje') ?></textarea>
              <?php if($validation->getError('mensaje')): ?>
                <div class="text-danger small mt-1">
                  <?= $validation->getError('mensaje') ?>
                </div>
              <?php endif; ?>
            </div>
            
          <div class="d-flex justify-content-between mt-4">
    
              <?php if (session()->get('id_usuario')): ?>
                  <a href="<?php echo base_url('panel'); ?>" class="btn btn-primary">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                          <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                      </svg> Volver al Panel
                  </a>
              <?php else: ?>
                  <a href="<?php echo base_url('/'); ?>" class="btn btn-secondary">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                          <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5Z"/>
                      </svg> Inicio
                  </a>
              <?php endif; ?>

              <button type="submit" class="btn btn-success">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
                      <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
                  </svg> Enviar Consulta
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
