<?php
namespace App\Controllers;
use CodeIgniter\Controller;
Use App\Models\producto_Model;
Use App\Models\Cabecera_model;
Use App\Models\VentaDetalle_model;
use Dompdf\Dompdf;

class Carrito_controller extends Controller{
    
    public function __construct(){
        helper(['form', 'url']);
    }

    // ********************************************
    // *** 1. MÉTODO DE REPORTES (NUEVO) **********
    // ********************************************
    public function mostrar_reportes() {
    $db = db_connect();
    $request = \Config\Services::request();
    
    $fechaDesde = $request->getGet('fecha_desde');
    $fechaHasta = $request->getGet('fecha_hasta');
    
    $data_grafico_productos = [];
    $data_grafico_pagos = [];

    if ($fechaDesde && $fechaHasta) {
        // 1. Datos para Gráfico de Productos (Agrupado por Categoría)
        $builderProd = $db->table('ventas_detalle vd');
        $builderProd->select('p.categoria_id, SUM(vd.cantidad) as total_vendido');
        $builderProd->join('productos p', 'p.id_producto = vd.producto_id');
        $builderProd->join('ventas_cabecera vc', 'vc.id = vd.venta_id');
        $builderProd->where('vc.fecha >=', $fechaDesde);
        $builderProd->where('vc.fecha <=', $fechaHasta);
        $builderProd->groupBy('p.categoria_id');
        $data_grafico_productos = $builderProd->get()->getResultArray();

        // 2. Datos para Gráfico de Formas de Pago
        $builderPago = $db->table('ventas_cabecera vc');
        $builderPago->select('vc.tipo_pago, COUNT(vc.id) as cantidad');
        $builderPago->where('vc.fecha >=', $fechaDesde);
        $builderPago->where('vc.fecha <=', $fechaHasta);
        $builderPago->groupBy('vc.tipo_pago');
        $data_grafico_pagos = $builderPago->get()->getResultArray();
    }

    $dato['titulo'] = 'Panel de Estadísticas';
    $dato['prod_stats'] = $data_grafico_productos;
    $dato['pago_stats'] = $data_grafico_pagos;
    $dato['fecha_desde'] = $fechaDesde;
    $dato['fecha_hasta'] = $fechaHasta;

    echo view('header', $dato); 
    echo view('panel');
    echo view('back/admin/reportes_view', $dato);
    echo view('footer');
}

    // ********************************************
    // *** 2. MÉTODOS DE VISTAS Y LISTADOS ********
    // ********************************************
    
    // Rescata las ventas cabeceras y muestra (Admin)
    
    // Rescata las ventas cabeceras de este cliente y muestra.
   public function ListComprasCabecera() {
    $db = db_connect();
    $request = \Config\Services::request();
    
    // Capturamos las fechas (si existen en el GET)
    $fechaDesde = $request->getGet('fecha_desde');
    $fechaHasta = $request->getGet('fecha_hasta');

    $builder = $db->table('ventas_cabecera u');
    $builder->select('u.id, d.nombre, d.apellido, u.total_venta, u.fecha, u.tipo_pago');
    $builder->join('usuarios d', 'u.usuario_id = d.id_usuario');

    // SOLO aplica el filtro si AMBAS fechas están presentes
    // Esto garantiza que al entrar normalmente siga funcionando igual
    if (!empty($fechaDesde) && !empty($fechaHasta)) {
        $builder->where('u.fecha >=', $fechaDesde);
        $builder->where('u.fecha <=', $fechaHasta);
    }

    $query = $builder->get();
    $ventas = ($query) ? $query->getResultArray() : [];

    // Pasamos las fechas a la vista para que queden escritas en los inputs
    $datos = [
        'ventas'      => $ventas,
        'fecha_desde' => $fechaDesde,
        'fecha_hasta' => $fechaHasta
    ];
    
    $data['titulo'] = 'Listado de Compras'; 
    echo view('header', $data);
    echo view('panel');
    echo view('back/admin/ListaCompras_view', $datos);
    echo view('footer');
}

    // Muestra el detalle de una compra específica
    public function ListCompraDetalle($id){
        $db = db_connect();
        $builder = $db->table('ventas_detalle u');
        $builder->where('venta_id',$id);
        $builder->select('d.id_producto , d.nombre_prod , u.cantidad , u.precio , u.total');
        $builder->join('productos d','u.producto_id = d.id_producto');
        
        $ventas = $builder->get();

        if ($ventas === false) {
            $error = $db->error();
            echo "Error en la consulta: " . $error['message'];
            return;
        }

        $resultArray = $ventas->getResultArray();
        $datos['ventas'] = $resultArray;
    
        $data['titulo'] = 'Listado de Compras'; 
        echo view('header', $data);
        echo view('panel');
        echo view('back/admin/CompraDetalle_view', $datos);
        echo view('footer');
    }

    // Muestra los productos en el carrito
    public function productosAgregados(){
        $cart = \Config\Services::cart();
        $carrito['carrito']=$cart->contents();
        $data['titulo']='Productos en el Carrito'; 
        echo view('header',$data);
        echo view('panel');
        echo view('back/carrito/ProductosEnCarrito',$carrito);
        echo view('footer');
    }

    // Muestra la vista de confirmación de compra
    function muestra_compra()
    {
        $data['titulo'] = 'Confirmar compra';

        echo view('header',$data);
        echo view('panel');
        echo view('back/carrito/compra');
        echo view('footer');
    }


    public function ListComprasCabeceraCliente($id)
{
    $db = db_connect();
    
    // 1. Selección y Join corregidos
    $builder = $db->table('ventas_cabecera u');
    // Usamos id_usuario que es tu PK real en la tabla usuarios
    $builder->join('usuarios d', 'u.usuario_id = d.id_usuario'); 
    
    // 2. Filtro por el ID del cliente que viene por la URL
    $builder->where('u.usuario_id', $id);
    
    // 3. Campos necesarios
    $builder->select('u.id, d.nombre, d.apellido, u.total_venta, u.fecha, u.tipo_pago');
    
    $query = $builder->get();
    $datos['ventas'] = $query->getResultArray();
    
    // 4. Variables para la vista (agregamos fechas nulas para evitar errores en los inputs de filtro)
    $datos['fecha_desde'] = null;
    $datos['fecha_hasta'] = null;

    $data['titulo'] = 'Mis Compras'; 
    
    // 5. Vistas (Cambié 'nav_view' por 'panel' que es lo que venís usando)
    echo view('header', $data);
    echo view('panel'); 
    echo view('back/admin/ListaCompras_view', $datos);
    echo view('footer');
}

  

    function GraciasPorSuCompra($id_venta = null)
    {
        $data['titulo'] ='Compra Realizada con Éxito';
        $data['id_venta'] = $id_venta; // Pasamos el ID a la vista

        echo view('header',$data);
        echo view('panel');
        echo view('back/carrito/GraciasCompra_view', $data);
        echo view('footer');
    }


    // ********************************************
    // *** 3. MÉTODOS DE LÓGICA DE CARRITO ********
    // ********************************************

   // Agrega elemento al carrito
    function add()
    {
        $cart = \Config\Services::cart();
        $request = \Config\Services::request();
        
        // Capturamos los datos básicos del POST
        $id = $request->getPost('id_producto');
        $nombre = $request->getPost('nombre_prod');
        $precio_vta = $request->getPost('precio_vta'); // Precio original por defecto

        // --- LÓGICA DE SEGURIDAD PARA OFERTAS ---
        $ProductoModel = new \App\Models\producto_Model();
        $producto_db = $ProductoModel->find($id);

        // Si el producto existe y tiene la promo activa, recalculamos el precio REAL
        if ($producto_db && $producto_db['promo_activada'] == 1) {
            $porcentaje = $producto_db['descuento_porcentaje'];
            $precio_vta = $producto_db['precio_vta'] - ($producto_db['precio_vta'] * $porcentaje / 100);
        }
        // ----------------------------------------

        // Genera array para insertar en el carrito con el precio validado
        $cart->insert(array(
            'id'      => $id,
            'qty'     => 1,
            'price'   => $precio_vta, // Aquí viaja el precio con o sin descuento según corresponda
            'name'    => $nombre,
        ));

        // Mensaje de éxito
        session()->setFlashdata('msg', '¡Producto añadido al carrito!');

        // Redirige a la misma página que se encuentra
        return redirect()->to(base_url('catalogo'));
    }

    // METODO ELIMINAR Elimina elemento del carrito o el carrito entero
    function remove($rowid){
        $cart = \Config\Services::cart();
        //Si $rowid es "all" destruye el carrito
        if ($rowid==="all")
        {
            $cart->destroy();
            session()->setFlashdata('msg', 'Se ha vaciado el carrito.');
        }
        else //Sino destruye sola fila seleccionada
        {
            $cart->remove($rowid);
            session()->setFlashdata('msg','Producto Eliminado del carrito');
            // Actualiza los datos
            
        }
        
        // Redirige a la misma página que se encuentra
        return redirect()->to(base_url('CarritoList'));
    }

    // METODO ACTUALIZAR Actualiza el carrito que se muestra
function actualiza_carrito()
{
    $cart = \Config\Services::cart();
    $Producto_model = new \App\Models\producto_Model(); 
    
    $cart_info = $_POST['cart'];
    
    foreach ($cart_info as $id => $carrito) {
        $qty = $carrito['qty'];

        // 1. VALIDACIÓN DE CANTIDAD POSITIVA (Se mantiene tu lógica)
        if ($qty <= 0) {
            session()->setFlashdata('error', "La cantidad debe ser mayor a 0. Para eliminar un producto, usa el icono de la basura.");
            return redirect()->to(base_url('CarritoList'));
        }

        $producto = $Producto_model->find($carrito['id']); 
        
        // 2. VALIDACIÓN DE STOCK (Se mantiene tu lógica)
        if ($producto && $qty > $producto['stock']) {
            session()->setFlashdata('error', "No se puede actualizar: '{$producto['nombre_prod']}' solo tiene {$producto['stock']} unidades disponibles.");
            return redirect()->to(base_url('CarritoList'));
        }
        
        // 3. ACTUALIZACIÓN SEGURA
        // Solo enviamos rowid y qty. La librería recalcula el subtotal automáticamente.
        $cart->update(array(
            'rowid' => $carrito['rowid'],
            'qty'   => $qty
        ));
    }

    session()->setFlashdata('msg', 'Carrito actualizado correctamente');
    return redirect()->to(base_url('CarritoList'));
}
    
public function guarda_compra()
{
    $cart = \Config\Services::cart();
    $session = session();
    $db = \Config\Database::connect(); // Necesario para las transacciones

    // 1. Instanciar modelos
    $cabecera_model = new \App\Models\Cabecera_model();
    $VentaDetalle_model = new \App\Models\VentaDetalle_model();
    $Producto_model = new \App\Models\producto_Model();

    $usuario_id = $session->get('id_usuario'); 
    if (!$usuario_id) {
        return redirect()->to(base_url('login'))->with('msg', 'Sesión expirada');
    }

    // --- INICIO DE TRANSACCIÓN ---
    // Esto asegura que si falla el detalle, no se guarde la cabecera (y viceversa)
    $db->transStart();

    // 2. Preparar datos de cabecera
    $datosCabecera = [
        'fecha'       => date('Y-m-d'),
        'usuario_id'  => $usuario_id,
        'total_venta' => $cart->total(), 
        'tipo_pago'   => $this->request->getPost('tipo_pago')
    ];

    // Insertamos. Al quitar 'id' de allowedFields en el modelo, CI4 lo maneja solo.
    $id_cabecera = $cabecera_model->insert($datosCabecera); 

    // 3. Insertar Detalles y Actualizar Stock
    if ($id_cabecera) {
        foreach ($cart->contents() as $item) {
            // Guardar Detalle
            $VentaDetalle_model->insert([
                'venta_id'    => $id_cabecera,
                'producto_id' => $item['id'],
                'cantidad'    => $item['qty'],   // Aquí se graban las 90 (o las que sean)
                'precio'      => $item['price'],
                'total'       => $item['subtotal']
            ]);

            // Actualizar Stock en la tabla 'productos'
            $producto = $Producto_model->find($item['id']);
            if ($producto) {
                $nuevoStock = $producto['stock'] - $item['qty'];
                $Producto_model->update($item['id'], [
                    'stock' => ($nuevoStock < 0 ? 0 : $nuevoStock)
                ]);
            }
        }
    }

    $db->transComplete();
    // --- FIN DE TRANSACCIÓN ---

    if ($db->transStatus() === FALSE) {
        // Si algo falló en la DB, cancela todo
        return "Error crítico: No se pudo completar la transacción en la base de datos.";
    } else {
        // Si todo salió bien, limpiamos carrito y redirigimos
        $cart->destroy(); 
        return redirect()->to(base_url('Gracias/' . $id_cabecera));
    }
}

// FACTURA PARA EL ADMIN (Vista previa en pantalla)
function FacturaAdmin($id)
{
    $db = db_connect();
    
    // Cabecera
    $builder2 = $db->table('ventas_cabecera a');
    $builder2->where('a.id', $id);
    $builder2->select('a.id, c.nombre, c.apellido, a.total_venta, a.fecha, a.tipo_pago');
    $builder2->join('usuarios c', 'a.usuario_id = c.id_usuario'); // <-- Corregido a id_usuario
    $datos2['datos'] = $builder2->get()->getResultArray();

    // Detalle
    $builder = $db->table('ventas_detalle u');
    $builder->where('venta_id', $id);
    $builder->select('d.id_producto, d.nombre_prod, u.cantidad, u.precio, u.total');
    $builder->join('productos d', 'u.producto_id = d.id_producto'); // <-- Usando tus nombres reales
    $datos['ventas'] = $builder->get()->getResultArray();
    
    $data['titulo'] = 'Factura';

    echo view('header', $data);
    echo view('panel');
    echo view('back/admin/facturacion_view', $datos2 + $datos);
    echo view('footer');
}

// FACTURA PARA EL CLIENTE (Descarga PDF)
function FacturaCliente($id)
{
    $dompdf = new \Dompdf\Dompdf(); // Asegúrate de que la ruta sea correcta
    $db = db_connect();
    
    // Datos de la cabecera
    $builder2 = $db->table('ventas_cabecera a');
    $builder2->where('a.id', $id);
    $builder2->select('a.id, c.nombre, c.apellido, a.total_venta, a.fecha, a.tipo_pago');
    $builder2->join('usuarios c', 'a.usuario_id = c.id_usuario'); // <-- Corregido a id_usuario
    $datos_cabecera = $builder2->get()->getResultArray();

    // Detalle de la venta
    $builder = $db->table('ventas_detalle u');
    $builder->where('venta_id', $id);
    $builder->select('d.id_producto, d.nombre_prod, u.cantidad, u.precio, u.total');
    $builder->join('productos d', 'u.producto_id = d.id_producto');
    $datos_detalle = $builder->get()->getResultArray();
    
    $total_final = !empty($datos_cabecera) ? $datos_cabecera[0]['total_venta'] : 0;

    $data_vista = [
        'datos'       => $datos_cabecera,
        'ventas'      => $datos_detalle,
        'total_venta' => $total_final 
    ];

    $html = view('back/admin/facturacion_view', $data_vista);
    
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    
    $dompdf->stream("Factura_Blass_#$id.pdf", ['Attachment' => true]);
}
}
