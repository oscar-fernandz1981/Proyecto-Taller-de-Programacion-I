<br>
<div class="container mt-1 mb-0">
    <div class="card fondo2 text-dark container" style="width: 50%;">
        <div class="card-header text-center">
            <h2>Mi Perfil</h2>
            <p class="text-muted">Actualiza tu información personal</p>
        </div>

       <?php if (session()->getFlashdata('msg')): ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-check-circle me-2"></i> 
            <div>
                <?= session()->getFlashdata('msg'); ?>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
        <?php if (!empty(session()->getFlashdata('fail'))): ?>
            <div class="alert alert-danger text-center mt-2">
                <?= session()->getFlashdata('fail'); ?>
            </div>
        <?php endif ?>

        <?php $validation = \Config\Services::validation(); ?>

        <form method="post" action="<?php echo base_url('/actualizarDatos') ?>" enctype="multipart/form-data">
            <?= csrf_field(); ?>

            <div class="card-body">
                
               <div class="card-body">
    
              <div class="text-center mb-4">
                    <?php $fotoPerfil = $data['perfil_img'] ?? ''; ?>

                    <?php if (!empty($fotoPerfil)): ?>
                        <img class="rounded-circle border border-3 border-primary shadow" 
                            src="<?= base_url('assets/uploads/' . $fotoPerfil) .'?' . time()  ?>" 
                            width="150" height="150" 
                            style="object-fit: cover;"
                            alt="Foto de perfil">
                            <?php else: ?>
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center border shadow-sm" 
                            style="width: 150px; height: 150px;">
                            <i class="fas fa-user fa-5x text-secondary"></i>
                        </div>
                        <p class="text-muted mt-2 small">Sin foto de perfil</p>
                    <?php endif; ?>
                </div>


                <div class="mb-3">
                    <label class="form-label fw-bold">Cambiar Foto de Perfil</label>
                    <input name="perfil_img" type="file" class="form-control">
                    <?php if ($validation->getError('perfil_img')): ?>
                        <div class='alert alert-danger mt-2'><?= $validation->getError('perfil_img'); ?></div>
                    <?php endif; ?>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label class="form-label fw-bold">Nombre</label>
                        <input name="nombre" type="text" class="form-control" value="<?= $data['nombre'] ?>">
                        <?php if ($validation->getError('nombre')): ?>
                            <div class='alert alert-danger mt-2'><?= $validation->getError('nombre'); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label fw-bold">Apellido</label>
                        <input type="text" name="apellido" class="form-control" value="<?= $data['apellido'] ?>">
                        <?php if ($validation->getError('apellido')): ?>
                            <div class='alert alert-danger mt-2'><?= $validation->getError('apellido'); ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">DNI</label>
                    <input name="dni" type="text" class="form-control" placeholder="Ingresa tu DNI" maxlength="8" value="<?= $data['dni'] ?? '' ?>">
                    <?php if ($validation->getError('dni')): ?>
                        <div class='alert alert-danger mt-2'><?= $validation->getError('dni'); ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <input name="email" type="email" class="form-control" value="<?= $data['email'] ?>">
                    <?php if ($validation->getError('email')): ?>
                        <div class='alert alert-danger mt-2'><?= $validation->getError('email'); ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Nombre de Usuario</label>
                    <input type="text" name="usuario" class="form-control" value="<?= $data['usuario'] ?>">
                    <?php if ($validation->getError('usuario')): ?>
                        <div class='alert alert-danger mt-2'><?= $validation->getError('usuario'); ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Contraseña (Dejar en blanco para no cambiar)</label>
                    <input name="pass" type="password" class="form-control" placeholder="Nueva contraseña">
                    <?php if ($validation->getError('pass')): ?>
                        <div class='alert alert-danger mt-2'><?= $validation->getError('pass'); ?></div>
                    <?php endif; ?>
                </div>

                <input type="hidden" name="id_usuario" value="<?= $data['id_usuario'] ?>">

                <div class="mt-4">
                    <input type="submit" value="Guardar Cambios" class="btn btn-outline-success float-end ms-2">
                    <a href="<?= base_url('panel'); ?>" class="btn btn-outline-danger float-end">Cancelar</a>
                </div>
                <br><br>
            </div>
        </form>
    </div>
</div>
<br>