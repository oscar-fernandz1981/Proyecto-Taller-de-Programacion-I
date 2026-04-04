<?php
$session = session();
$nombre  = $session->get('nombre');
$perfil  = $session->get('perfil_id'); // 1 para Admin, 2 para Cliente, null para Visitante
$id      = $session->get('id_usuario');
$uri     = uri_string();
?>

<nav class="navbar sticky-top navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?php echo base_url()?>">
      <img src="<?php echo base_url('assets/img/BLASS-1.jpg');?>" width="100" height="100">
    </a>
    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      
      <?php if ($perfil == 1 || $perfil == 2): ?>
        
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <?php if($perfil == 1): ?>
            <li class="nav-item me-2"><span class="nav-link text-info fw-bold">ADMIN: <?= $nombre ?></span></li>
            <li class="nav-item"><a class="nav-link <?= ($uri == 'usuarios-list') ? 'fw-bold text-primary text-decoration-underline active' : '' ?>" href="<?= base_url('usuarios-list')?>">Usuarios</a></li>
            <li class="nav-item"><a class="nav-link <?= ($uri == 'Lista_Productos') ? 'fw-bold text-primary text-decoration-underline active' : '' ?>" href="<?= base_url('Lista_Productos')?>">Productos</a></li>
            <li class="nav-item"><a class="nav-link <?= ($uri == 'compras') ? 'fw-bold text-primary text-decoration-underline active' : '' ?>" href="<?= base_url('compras')?>">Ventas-Compras</a></li>
            <li class="nav-item"><a class="nav-link <?= ($uri == 'ReportesVentas') ? 'fw-bold text-primary text-decoration-underline active' : '' ?>" href="<?= base_url('ReportesVentas')?>">Reportes</a></li>
          
          <?php elseif($perfil == 2): ?>
            <li class="nav-item me-2"><span class="nav-link text-info fw-bold">CLIENTE: <?= $nombre ?></span></li>
            <li class="nav-item"><a class="nav-link <?= ($uri == 'contact-form') ? 'fw-bold text-primary text-decoration-underline active' : '' ?>" href="<?= base_url('contact-form')?>">Consultar</a></li>
            <li class="nav-item"><a class="nav-link <?= ($uri == 'catalogo') ? 'fw-bold text-primary text-decoration-underline active' : '' ?>" href="<?= base_url('catalogo')?>">Catálogo</a></li>
            <li class="nav-item"><a class="nav-link <?= ($uri == 'CarritoList') ? 'fw-bold text-primary text-decoration-underline active' : '' ?>" href="<?= base_url('CarritoList')?>">Mi Carrito</a></li>
            <li class="nav-item"><a class="nav-link <?= (strpos($uri, 'misCompras') !== false) ? 'fw-bold text-primary text-decoration-underline active' : '' ?>" href="<?= base_url('misCompras/'.$id)?>">Mis compras</a></li>
          <?php endif; ?>
        </ul>

        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link fw-bold text-danger" href="<?= base_url('logout')?>">Cerrar Sesión</a>
          </li>
        </ul>

      <?php else: ?>
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link <?= ($uri == '' || $uri == '/') ? 'fw-bold text-primary text-decoration-underline active' : '' ?>" href="<?= base_url()?>">Inicio</a></li>
          <li class="nav-item"><a class="nav-link <?= ($uri == 'somos') ? 'fw-bold text-primary text-decoration-underline active' : '' ?>" href="<?= base_url('somos')?>">Somos</a></li>
          <li class="nav-item"><a class="nav-link <?= ($uri == 'catalogo') ? 'fw-bold text-primary text-decoration-underline active' : '' ?>" href="<?= base_url('catalogo')?>">Productos</a></li>
          <li class="nav-item"><a class="nav-link <?= ($uri == 'promociones') ? 'fw-bold text-primary text-decoration-underline active' : '' ?>" href="<?= base_url('promociones')?>">Promociones</a></li>
          <li class="nav-item"><a class="nav-link <?= ($uri == 'contacto') ? 'fw-bold text-primary text-decoration-underline active' : '' ?>" href="<?= base_url('contacto')?>">Contacto</a></li>
        </ul>

        <form class="d-flex">
          <a href="<?= base_url('login')?>" class="btn btn-outline-success me-2">Ingresar</a>
          <a href="<?= base_url('registro')?>" class="btn btn-outline-secondary">Registrate</a>
        </form>
      <?php endif; ?>

    </div>
  </div>
</nav>