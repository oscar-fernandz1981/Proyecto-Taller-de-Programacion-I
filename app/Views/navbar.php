<?php $uri = uri_string(); ?>

<nav class="navbar navbar-expand-lg navbar-light sticky-top" style="background-color: #e3f2fd;">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo base_url()?>">
            <img src="<?php echo base_url('assets/img/BLASS-1.jpg'); ?>" width="100" height="100">
        </a>
        <button class="navbar-toggler bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= ($uri == '' || $uri == '/') ? 'fw-bold text-primary active text-decoration-underline' : '' ?>" href="<?php echo base_url()?>">Inicio</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= ($uri == 'somos') ? 'fw-bold text-primary active text-decoration-underline' : '' ?>" href="<?php echo base_url('somos')?>">Somos</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= ($uri == 'catalogo') ? 'fw-bold text-primary active text-decoration-underline' : '' ?>" href="<?php echo base_url('catalogo')?>">Productos</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= ($uri == 'promociones') ? 'fw-bold text-primary active text-decoration-underline' : '' ?>" href="<?php echo base_url('promociones')?>">Promociones</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= ($uri == 'contacto') ? 'fw-bold text-primary active text-decoration-underline' : '' ?>" href="<?php echo base_url('contacto');?>">Contacto</a>
                </li>
            </ul>

            <div class="d-flex">
                <a href="<?php echo base_url('login')?>" class="btn <?= ($uri == 'login') ? 'btn-success fw-bold' : 'btn-outline-success' ?> my-2 my-sm-0">Ingresar</a>
                &nbsp;
                <a href="<?php echo base_url('registro')?>" class="btn <?= ($uri == 'registro') ? 'btn-secondary fw-bold' : 'btn-outline-secondary' ?>">Registrate</a>
            </div>
        </div>
    </div>
</nav>