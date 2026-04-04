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
    public function mostrar_reportes()
    {
        $db = db_connect();
        $request = \Config\Services::request();
        
        $ventas_periodo = [];

        // Obtener las fechas de filtro desde la URL (método GET)
        $fechaDesde = $request->getGet('fecha_desde');
        $fechaHasta = $request->getGet('fecha_hasta');
        
        // Si se enviaron las fechas, realizar la consulta
        if ($fechaDesde && $fechaHasta) {
            
            $builder = $db->table('ventas_cabecera vc');
            
            // Seleccionar los campos necesarios para la tabla de reportes
            $builder->select('vc.fecha, u.nombre as cliente_nombre, u.apellido as cliente_apellido, p.nombre_prod as producto_nombre, vd.cantidad, vd.precio, vd.total');
            
            // Unir la cabecera con el detalle
            $builder->join('ventas_detalle vd', 'vd.venta_id = vc.id');
            // Unir el detalle con los productos
            $builder->join('productos p', 'p.id_producto = vd.producto_id');
            // Unir la cabecera con los usuarios
            $builder->join('usuarios u', 'u.id_usuario = vc.usuario_id');
            
            // Aplicar el filtro de rango de fechas
            $builder->where('vc.fecha >=', $fechaDesde); 
            $builder->where('vc.fecha <=', $fechaHasta); 
            
            $builder->orderBy('vc.fecha', 'DESC');

            $query = $builder->get();
            $ventas_periodo = $query->getResultArray();
            
            // Ajustar el nombre del cliente para la vista
            foreach ($ventas_periodo as $key => $venta) {
                $ventas_periodo[$key]['cliente_nombre'] = $venta['cliente_nombre'] . ' ' . $venta['cliente_apellido'];
            }
        }
        
        $dato['titulo'] = 'Reportes Detallados de Venta';
        $dato['ventas_periodo'] = $ventas_periodo; // Pasar los datos a la vista



        $dato['fecha_desde'] = $fechaDesde;
        $dato['fecha_hasta'] = $fechaHasta;
        // Cargar las vistas
        echo view('header',$dato); 
        echo view('panel');
        echo view('back/admin/reportes_view', $dato); // Pasar la variable $dato
        echo view('footer2');
    }

    // ********************************************
    // *** 2. MÉTODOS DE VISTAS Y LISTADOS ********
    // ********************************************
    
    // Rescata las ventas cabeceras y muestra (Admin)
    public function ListComprasCabecera(){
        $db = db_connect();
        $builder = $db->table('ventas_cabecera u');
        $builder->select('u.id , d.nombre , d.apellido, u.total_venta , u.fecha , u.tipo_pago');
        $builder->join('usuarios d','u.usuario_id = d.id_usuario');
        $query = $builder->get();

        if ($query === false) {
            $error = $db->error();
            echo "Error en la consulta: " . $error['message'];
            return;
        }

        $ventas = $query->getResultArray();
        $datos['ventas'] = $ventas;
        
        $data['titulo']='Listado de Compras'; 
        echo view('header',$data);
        echo view('panel');
        echo view('back/admin/ListaCompras_view',$datos);
        echo view('footer2');
    }

    // Rescata las ventas cabeceras de este cliente y muestra.
    public function ListComprasCabeceraCliente($id){
        $db = db_connect();
        $builder = $db->table('ventas_cabecera u');
        $builder->where('usuario_id', $id);
        $builder->select('u.id, d.nombre, d.apellido, u.total_venta, u.fecha, u.tipo_pago');
        $builder->join('usuarios d', 'u.usuario_id = d.id_usuario');
        $query = $builder->get();

        if ($query === false) {
            $error = $db->error();
            echo "Error en la consulta: " . $error['message'];
            return;
        }

        $ventas = $query->getResultArray();
        $datos['ventas'] = $ventas;

        $data['titulo'] = 'Listado de Compras';
        echo view('header', $data);
        echo view('panel');
        echo view('back/admin/ListaCompras_view', $datos);
        echo view('footer2');
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
        echo view('footer2');
    }

    // Muestra los productos en el carrito
    public function productosAgregados(){
        $cart = \Config\Services::cart();
        $carrito['carrito']=$cart->contents();
        $data['titulo']='Productos en el Carrito'; 
        echo view('header',$data);
        echo view('panel');
        echo view('back/carrito/ProductosEnCarrito',$carrito);
        echo view('footer2');
    }

    // Muestra la vista de confirmación de compra
    function muestra_compra()
    {
        $data['titulo'] = 'Confirmar compra';

        echo view('header',$data);
        echo view('panel');
        echo view('back/carrito/compra');
        echo view('footer2');
    }

    /* Muestra la vista de agradecimiento
    function GraciasPorSuCompra()
    {
        $data['titulo'] ='Confirmar Realizada';

        echo view('header',$data);
        echo view('panel');
        echo view('back/carrito/GraciasCompra_view');
        echo view('footer2');
    }*/

    function GraciasPorSuCompra($id_venta = null)
    {
        $data['titulo'] ='Compra Realizada con Éxito';
        $data['id_venta'] = $id_venta; // Pasamos el ID a la vista

        echo view('header',$data);
        echo view('panel');
        echo view('back/carrito/GraciasCompra_view', $data);
        echo view('footer2');
    }


    // ********************************************
    // *** 3. MÉTODOS DE LÓGICA DE CARRITO ********
    // ********************************************

    // Agrega elemento al carrito
    function add()
    {
        $cart = \Config\Services::cart();
        // Genera array para insertar en el carrito
        $cart->insert(array(
            'id'      => $_POST['id_producto'],
            'qty'     => 1,
            'price'   => $_POST['precio_vta'],
            'name'    => $_POST['nombre_prod'],
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
        // Recibe los datos del carrito, calcula y actualiza
        $cart_info =  $_POST['cart'];
        
        foreach( $cart_info as $id => $carrito)
        {   
            
            $rowid = $carrito['rowid'];
            $price = $carrito['price'];
            $amount = $price * $carrito['qty'];
            $qty = $carrito['qty'];
            

            $cart->update(array(
                'rowid'   => $rowid,
                'price'   => $price,
                'amount' =>  $amount,
                'qty'     => $qty
                ));       
                 
        }
        session()->setFlashdata('msg','Carrito actualizado correctamente');
        // Redirige a la misma página que se encuentra
        return redirect()->to(base_url('CarritoList'));
    }

    /* Guarda los datos de la venta en la base de datos
    public function guarda_compra()
    {
        $cart = \Config\Services::cart();
        $session = session();
        $usuario_id= $session->get('id_usuario');

        $total = $_POST['total_venta'];
        $tipo_Pago = $_POST['tipo_pago'];

        $cabecera_model = new Cabecera_model();
        $ventas_id = $cabecera_model->save([
            'fecha'         => date('Y-m-d'),
            'usuario_id'    => $usuario_id,
            'total_venta'   => $total,
            'tipo_pago'     => $tipo_Pago
        ]);
        // Rescato el ID de la cabecera que se guardo
        $id_cabecera = $cabecera_model->getInsertID();
        
        if ($cart):
            foreach ($cart->contents() as $item):
                $VentaDetalle_model = new VentaDetalle_model();
                $VentaDetalle_model->save([
                    'venta_id'      => $id_cabecera,
                    'producto_id'   => $item['id'],
                    'cantidad'      => $item['qty'],
                    'precio'        => $item['price'],
                    'total'         => $item['subtotal']
                ]);

                // Descuenta del stock y lo guarda en la base de datos
                $Producto_model = new producto_Model();
                $producto = $Producto_model->find($item['id']);
                
                // Asegurar que el producto existe antes de restar stock
                if ($producto) {
                    $stock = $producto['stock'];
                    $stock_edit = $stock - $item['qty'];
                    
                    // Asegurar que el stock no sea negativo
                    if ($stock_edit < 0) {
                        $stock_edit = 0; 
                        // NOTA: Aquí debería haber una validación antes de guardar la compra!
                    }

                    $datos=[
                        'stock'  => $stock_edit,
                    ];
                    $Producto_model->update($item['id'],$datos);
                }
            endforeach;
        endif;

        $cart->destroy();
        return redirect()->to(base_url('Gracias'));
    }
        

    public function guarda_compra()
    {
        $cart = \Config\Services::cart();
        $session = session();
        
        // El ID de usuario suele ser 'id' o 'id_usuario' según tu session, 
        // revisa cual usas. Aquí uso 'id' que es el estándar.
        $usuario_id = $session->get('id_usuario'); 

        $total = $cart->total();
        // Capturamos el tipo de pago del formulario de ConfigurarPago_view
        $tipo_Pago = $this->request->getPost('metodoPago'); 

        $cabecera_model = new Cabecera_model();
        
        // Guardamos la cabecera
        $cabecera_model->save([
            'fecha'         => date('Y-m-d'),
            'usuario_id'    => $usuario_id,
            'total_venta'   => $total,
            'tipo_pago'     => $tipo_Pago
        ]);

        $id_cabecera = $cabecera_model->getInsertID();
        
        if ($cart->contents()):
            foreach ($cart->contents() as $item):
                $VentaDetalle_model = new VentaDetalle_model();
                $VentaDetalle_model->save([
                    'venta_id'      => $id_cabecera,
                    'producto_id'   => $item['id'],
                    'cantidad'      => $item['qty'],
                    'precio'        => $item['price'],
                    'total'         => $item['subtotal']
                ]);


                /* 1. Guardamos la cabecera y capturamos el ID
                $id_cabecera = $cabecera_model->insert([
                'fecha'         => date('Y-m-d'),
                'usuario_id'    => $usuario_id,
                'total_venta'   => $total,
                'tipo_pago'     => $tipo_Pago
                 ]);
                 

                // Descuenta del stock
                $Producto_model = new producto_Model();
                $producto = $Producto_model->find($item['id']);
                
                if ($producto) {
                    $stock_edit = $producto['stock'] - $item['qty'];
                    if ($stock_edit < 0) $stock_edit = 0; 

                    $Producto_model->update($item['id'], ['stock' => $stock_edit]);
                }
            endforeach;
        endif;

        $cart->destroy();
        // 2. REDIRECCIÓN CRUCIAL: Pasamos el ID a la URL
        //return redirect()->to(base_url('Gracias/' . $id_cabecera));
        // Redirigimos a Gracias enviando el ID para que pueda descargar su factura
        return redirect()->to(base_url('Gracias/'.$id_cabecera));
    }
    



    public function guarda_compra()
{
    $cart = \Config\Services::cart();
    $session = session();


    $cabecera_model = new \App\Models\Cabecera_model();
    $datosCabecera = [
    'fecha'       => date('Y-m-d'),
    'usuario_id'  => $session->get('id_usuario'), 
    'total_venta' => $cart->total(),
    'tipo_pago'   => $this->request->getPost('metodoPago')
];

if ($cabecera_model->insert($datosCabecera)) {
    $id_cabecera = $cabecera_model->getInsertID();
} else {
    // Esto te dirá exactamente QUÉ campo está fallando en la base de datos
    print_r($cabecera_model->errors()); 
    die();
}
    



    // IMPORTANTE: Verifica si tu sesión usa 'id' o 'id_usuario'
    $usuario_id = $session->get('id_usuario'); 

    if (!$usuario_id) {
        return redirect()->to(base_url('login'))->with('msg', 'Sesión expirada');
    }

    $metodoPago = $this->request->getPost('metodoPago'); 
    $totalVenta = $cart->total();

    $cabecera_model = new Cabecera_model();
    
    // Usamos un array limpio para el insert
    $datosCabecera = [
        'fecha'       => date('Y-m-d'),
        'usuario_id'  => $usuario_id,
        'total_venta' => $totalVenta,
        'tipo_pago'   => $metodoPago
    ];

    // Ejecutamos el insert
    $cabecera_model->insert($datosCabecera);
    $id_cabecera = $cabecera_model->getInsertID(); // Aquí ya NO debería ser 0

    if ($id_cabecera > 0) {
        foreach ($cart->contents() as $item) {
            $VentaDetalle_model = new VentaDetalle_model();
            $VentaDetalle_model->insert([
                'venta_id'    => $id_cabecera,
                'producto_id' => $item['id'],
                'cantidad'    => $item['qty'],
                'precio'      => $item['price'],
                'total'       => $item['subtotal']
            ]);

            // Actualizar Stock
            $Producto_model = new producto_Model();
            $producto = $Producto_model->find($item['id']);
            if ($producto) {
                $nuevoStock = $producto['stock'] - $item['qty'];
                $Producto_model->update($item['id'], ['stock' => ($nuevoStock < 0 ? 0 : $nuevoStock)]);
            }
        }
        
        $cart->destroy();
        return redirect()->to(base_url('Gracias/' . $id_cabecera));
    } else {
        // Si llega aquí, hubo un error de DB
        return "Error al guardar la cabecera de venta.";
    }
}


    // ********************************************
    // *** 4. MÉTODOS DE FACTURACIÓN (PDF) ********
    // ********************************************

    function FacturaAdmin($id)
    {
        // Secciones de Dompdf comentadas (listas para descomentar cuando se necesite PDF)
        //$dompdf = new Dompdf();

        $db = db_connect();
        
        // Obtener datos de la cabecera
        $builder2 = $db->table('ventas_cabecera a');
        $builder2->where('a.id',$id);
        // NOTA: La columna de join de usuarios en el PDF es 'c.id', diferente a otras. Se mantiene el código original.
        $builder2->select('a.id , c.nombre , c.apellido, a.total_venta , a.fecha , a.tipo_pago');
        $builder2->join('usuarios c','a.usuario_id = c.id'); 
        $ventas2= $builder2->get();
        $datos2['datos']=$ventas2->getResultArray();

        // Obtener detalle de la venta
        $builder = $db->table('ventas_detalle u');
        $builder->where('venta_id',$id);
        // NOTA: La columna de join de productos en el PDF es 'd.id', diferente a otras. Se mantiene el código original.
        $builder->select('d.id_producto , d.nombre_prod , u.cantidad , u.precio , u.total ,');
        $builder->join('productos d','u.producto_id = d.id_producto
        ');
        $ventas= $builder->get();
        $datos['ventas']=$ventas->getResultArray();
        
        $data['titulo'] ='Factura';

        echo view('header',$data);
        echo view('panel');
        echo view('back/Admin/facturacion_view',$datos2+$datos);
        echo view('footer2');

        // Código para generar PDF (actualmente comentado)
        /*
        $html = view('back/Admin/facturacion_view',$datos2+$datos);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait'); // Se cambió a portrait por defecto
        $dompdf->render();
        $dompdf->stream('demoFactura.pdf',['attachment' => false]);
        
    }
    
    function FacturaCliente($id)
    {
        // Secciones de Dompdf comentadas (listas para descomentar cuando se necesite PDF)
        //$dompdf = new Dompdf();

        $db = db_connect();
        
        // Obtener datos de la cabecera
        $builder2 = $db->table('ventas_cabecera a');
        $builder2->where('a.id',$id);
        // NOTA: La columna de join de usuarios es 'c.id_usuario'. Se mantiene el código original.
        $builder2->select('a.id , c.nombre , c.apellido, a.total_venta , a.fecha , a.tipo_pago');
        $builder2->join('usuarios c','a.usuario_id = c.id_usuario');
        $ventas2= $builder2->get();
        $datos2['datos']=$ventas2->getResultArray();

        // Obtener detalle de la venta
        $builder = $db->table('ventas_detalle u');
        $builder->where('venta_id',$id);
        // NOTA: La columna de join de productos es 'd.id_producto'. Se mantiene el código original.
        $builder->select('d.id_producto , d.nombre_prod , u.cantidad , u.precio , u.total ,');
        $builder->join('productos d','u.producto_id = d.id_producto');
        $ventas= $builder->get();
        $datos['ventas']=$ventas->getResultArray();
        
        $data['titulo'] ='Factura';

        echo view('header',$data);
        echo view('panel');
        echo view('back/Admin/facturacion_view',$datos2+$datos);
        echo view('footer2');

        // Código para generar PDF (actualmente comentado)
        /*
        $html = view('back/Admin/facturacion_view',$datos2+$datos);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait'); // Se cambió a portrait por defecto
        $dompdf->render();
        $dompdf->stream('demoFactura.pdf',['attachment' => false]);
        
    }
       
    
    function FacturaCliente($id)
    {
        $dompdf = new Dompdf();
        $db = db_connect();
        
        // Datos de la cabecera
        $builder2 = $db->table('ventas_cabecera a');
        $builder2->where('a.id',$id);
        $builder2->select('a.id, c.nombre, c.apellido, a.total_venta, a.fecha, a.tipo_pago');
        $builder2->join('usuarios c','a.usuario_id = c.id_usuario');
        $ventas2= $builder2->get();
        $datos2['datos'] = $ventas2->getResultArray();

        // Detalle de la venta
        $builder = $db->table('ventas_detalle u');
        $builder->where('venta_id',$id);
        $builder->select('d.id_producto, d.nombre_prod, u.cantidad, u.precio, u.total');
        $builder->join('productos d','u.producto_id = d.id_producto');
        $ventas = $builder->get();
        $datos['ventas'] = $ventas->getResultArray();
        
        $html = view('back/admin/facturacion_view', $datos2 + $datos);
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        // Esto descarga el archivo directamente
        $dompdf->stream("Factura_Blass_#$id.pdf", ['Attachment' => true]);
    }
        


    function FacturaCliente($id)
    {
        $dompdf = new Dompdf();
        $db = db_connect();
        
        // Datos de la cabecera
        $builder2 = $db->table('ventas_cabecera a');
        $builder2->where('a.id',$id);
        $builder2->select('a.id, c.nombre, c.apellido, a.total_venta, a.fecha, a.tipo_pago');
        $builder2->join('usuarios c','a.usuario_id = c.id_usuario');
        $ventas2= $builder2->get();
        $datos2['datos'] = $ventas2->getResultArray();

        // Detalle de la venta
        $builder = $db->table('ventas_detalle u');
        $builder->where('venta_id',$id);
        $builder->select('d.id_producto, d.nombre_prod, u.cantidad, u.precio, u.total');
        $builder->join('productos d','u.producto_id = d.id_producto');
        $ventas = $builder->get();
        $datos['ventas'] = $ventas->getResultArray();
        
        // IMPORTANTE: Verifica que esta ruta sea la correcta en tus carpetas
        $html = view('back/admin/facturacion_view', $datos2 + $datos);
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        $dompdf->stream("Factura_Blass_#$id.pdf", ['Attachment' => true]);
    }
        


    function FacturaCliente($id)
{
    $dompdf = new Dompdf();
    $db = db_connect();
    
    // Datos de la cabecera
    $builder2 = $db->table('ventas_cabecera a');
    $builder2->where('a.id', $id);
    $builder2->select('a.id, c.nombre, c.apellido, a.total_venta, a.fecha, a.tipo_pago');
    $builder2->join('usuarios c', 'a.usuario_id = c.id_usuario');
    $ventas2 = $builder2->get();
    $datos_cabecera = $ventas2->getResultArray();

    // Detalle de la venta
    $builder = $db->table('ventas_detalle u');
    $builder->where('venta_id', $id);
    $builder->select('d.id_producto, d.nombre_prod, u.cantidad, u.precio, u.total');
    $builder->join('productos d', 'u.producto_id = d.id_producto');
    $ventas = $builder->get();
    $datos_detalle = $ventas->getResultArray();
    
    // EXTRAEMOS EL TOTAL AQUÍ:
    // Si hay datos, tomamos el total_venta del primer registro, sino 0.
    $total_final = !empty($datos_cabecera) ? $datos_cabecera[0]['total_venta'] : 0;

    // Pasamos todo de forma explícita en un solo array
    $data_vista = [
        'datos'       => $datos_cabecera,
        'ventas'      => $datos_detalle,
        'total_venta' => $total_final // <--- Ahora la vista siempre la recibirá
    ];

    $html = view('back/admin/facturacion_view', $data_vista);
    
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    
    $dompdf->stream("Factura_Blass_#$id.pdf", ['Attachment' => true]);
}


*/




public function guarda_compra()
{
    $cart = \Config\Services::cart();
    $session = session();
    $db = \Config\Database::connect();

    // 1. Instanciar los modelos necesarios
    $cabecera_model = new \App\Models\Cabecera_model();
    $VentaDetalle_model = new \App\Models\VentaDetalle_model();
    $Producto_model = new \App\Models\producto_Model();

    $usuario_id = $session->get('id_usuario'); 

    if (!$usuario_id) {
        return redirect()->to(base_url('login'))->with('msg', 'Sesión expirada');
    }


    // --- CAMBIO CLAVE AQUÍ: Coincidir con el 'name' del select de la vista ---
   //$metodo_pago_seleccionado = $this->request->getPost('tipo_pago');


   

    // 2. Preparar datos de cabecera
    $datosCabecera = [
        'fecha'       => date('Y-m-d'),
        'usuario_id'  => $usuario_id,
        'total_venta' => $cart->total(),
        'tipo_pago'   => $this->request->getPost('tipo_pago')
    ];

    // 3. Insertar cabecera y capturar ID real
    if ($cabecera_model->insert($datosCabecera)) {
        $id_cabecera = $cabecera_model->getInsertID(); 
    } else {
        // Si hay error de validación o DB, lo vemos acá
        print_r($cabecera_model->errors()); 
        die();
    }

    // 4. Insertar detalles y actualizar stock
    if ($id_cabecera > 0) {
        foreach ($cart->contents() as $item) {
            $VentaDetalle_model->insert([
                'venta_id'    => $id_cabecera,
                'producto_id' => $item['id'],
                'cantidad'    => $item['qty'],
                'precio'      => $item['price'],
                'total'       => $item['subtotal']
            ]);

            // Actualización de Stock
            $producto = $Producto_model->find($item['id']);
            if ($producto) {
                $nuevoStock = $producto['stock'] - $item['qty'];
                $Producto_model->update($item['id'], ['stock' => ($nuevoStock < 0 ? 0 : $nuevoStock)]);
            }
        }
        
        $cart->destroy();
        return redirect()->to(base_url('Gracias/' . $id_cabecera));
    } else {
        return "Error crítico: No se generó un ID de venta válido.";
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
    echo view('footer2');
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
