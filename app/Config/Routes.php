<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);
$routes->get('/somos', 'Home::somos');
$routes->get('/promociones', 'Home::promociones');
$routes->get('/condiciones', 'Home::condiciones');
$routes->get('contacto', 'FormController::create'); // O el controlador que cargue contacto.php
$routes->post('submit-form', 'FormController::formValidation');
$routes->get('catalogo', 'producto_controller::ProductosDisp');
//$routes->get('/productos', 'Home::productos');

// REGISTRO PÚBLICO - SIN FILTER
$routes->get('/registro', 'usuario_controller::create');
$routes->post('/enviar-form', 'usuario_controller::formValidation');

// LOGIN/LOGOUT - SIN FILTER
$routes->get('/login', 'login_controller::index');
$routes->post('/enviarlogin', 'login_controller::auth');
$routes->get('/logout', 'login_controller::logout');

// ==================== RUTAS DE ADMIN (SOLO PERFIL 1) ====================
$routes->group('', ['filter' => 'auth:1'], function($routes) {
    
    // PRODUCTOS - ADMIN
    $routes->get('/nuevoProducto', 'producto_controller::nuevoProducto');
    $routes->post('/ProductoValidation', 'producto_controller::ProductoValidation');
    $routes->get('/Lista_Productos', 'producto_controller::ListaProductos');
    $routes->post('/enviarEdicionProd', 'producto_controller::ProdValidationEdit');
    $routes->get('/eliminadosProd', 'producto_controller::ListaProductosElim');
    $routes->get('/deleteProd/(:num)', 'producto_controller::deleteProd/$1');
    $routes->get('/ProductoEdit/(:num)', 'producto_controller::getProductoEdit/$1');
    $routes->get('producto_controller/habilitarProd/(:num)', 'producto_controller::habilitarProd/$1');
    
    // USUARIOS - ADMIN

    $routes->post('/crearUs', 'usuario_controller::formValidationAdmin');
    $routes->get('/nuevoUs', 'usuario_controller::nuevoUsuario');
    $routes->get('/usuarios-list', 'Datatable_controller::index');
    $routes->get('/editar/(:num)', 'Datatable_controller::editar/$1');
    $routes->post('/enviarEdicion', 'usuario_controller::formValidationEdit');
    $routes->get('/eliminados', 'usuario_controller::usuariosEliminados');
    $routes->get('usuario_controller/delete/(:num)', 'usuario_controller::delete/$1');
    $routes->get('usuario_controller/habilitar/(:num)', 'usuario_controller::habilitar/$1');
    
    // CONSULTAS - ADMIN (Ver consultas recibidas)
    $routes->get('consultas', 'Contactocontroller::Datos_consultas');
    $routes->get('ConsultaDetalle/(:num)', 'Contactocontroller::ConsultaDetalle/$1');
    $routes->get('deleteConsulta/(:num)', 'Contactocontroller::deleteConsulta/$1');
    $routes->get('habilitarConsulta/(:num)', 'Contactocontroller::habilitarConsulta/$1');
    $routes->get('consultasResueltas', 'Contactocontroller::Datos_consultasResueltas');
    
    // VENTAS Y FACTURACIÓN - ADMIN
        //REPORTES
    $routes->get('/ReportesVentas', 'Carrito_controller::mostrar_reportes', ['filter' => 'auth:1']);
    
    
    $routes->get('compras', 'Carrito_controller::ListComprasCabecera');
    $routes->get('DetalleVta/(:num)', 'Carrito_controller::ListCompraDetalle/$1');
    $routes->get('PDF/(:num)', 'Carrito_controller::FacturaAdmin/$1');
    $routes->get('admin/estadisticas', 'Panel_controller::estadisticas');
    $routes->get('admin/reportes', 'Panel_controller::reportes');
});

// ==================== RUTAS DE CLIENTE (SOLO PERFIL 2) ====================
$routes->group('', ['filter' => 'auth:2'], function($routes) {
    
    // CATÁLOGO Y PRODUCTOS - CLIENTE
    $routes->get('/catalogo', 'producto_controller::ProductosDisp');
    $routes->get('/ProductoDetalle/(:num)', 'producto_controller::ProductoDetalle/$1');
    
    // CARRITO Y COMPRAS - CLIENTE
    $routes->get('CarritoList', 'Carrito_controller::productosAgregados');
    $routes->post('Carrito_agrega', 'Carrito_controller::add');
    $routes->get('carrito_elimina/(:any)', 'Carrito_controller::remove/$1');
    $routes->post('carrito_actualiza', 'Carrito_controller::actualiza_carrito');
    $routes->get('comprar', 'Carrito_controller::muestra_Compra');
    $routes->post('confirma_compra', 'Carrito_controller::guarda_compra');
    $routes->get('Gracias', 'Carrito_controller::GraciasPorSuCompra');
    $routes->get('Gracias/(:num)', 'Carrito_controller::GraciasPorSuCompra/$1');
    
    // MIS COMPRAS Y FACTURACIÓN - CLIENTE
    $routes->get('misCompras/(:num)', 'Carrito_controller::ListComprasCabeceraCliente/$1');
    $routes->get('factura/(:num)', 'Carrito_controller::FacturaCliente/$1');
    $routes->get('factura_cliente/(:num)', 'Carrito_controller::FacturaCliente/$1');
    
    // MI PERFIL - CLIENTE
    $routes->get('miPerfil', 'usuario_controller::miPerfil');
    $routes->get('editoMisDatos/(:num)', 'Datatable_controller::editoMisDatos/$1');
    $routes->post('/actualizarDatos', 'usuario_controller::usuarioEdit');
    
    // CONTACTO - CLIENTE (Enviar consultas) - ¡ELIGE UNA OPCIÓN!
     //Opción A: Usar FormController (el que YA funciona)
     $routes->get('contact-form', 'FormController::create');
     $routes->post('submit-form', 'FormController::formValidation');
    
    // Opción B: Usar Contactocontroller (nuevo)
    //$routes->get('contacto', 'Contactocontroller::contacto');
    //$routes->post('submit-form', 'Contactocontroller::submit');
});

// ==================== RUTAS PARA AMBOS PERFILES (1 y 2) ====================
$routes->group('', ['filter' => 'auth:1,2'], function($routes) {
    $routes->get('/panel', 'panel_controller::index');
    $routes->get('facturacion/(:num)', 'panel_controller::facturacion/$1');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}