<?php

namespace App\Controllers;

use App\Models\usuario_Model;
use CodeIgniter\Controller;

class panel_controller extends Controller
{
    public function index()
    {
        // Iniciar la sesión
        $session = session();

        // Verificar si el usuario ha iniciado sesión
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // Obtener los datos del usuario desde la sesión
       
        $usuarioModel= new usuario_Model();
        $usuario= $usuarioModel->find($session->get('id_usuario'));
        //$username = $session->get('username');

        //verificar si se obtuvo el usuario
        if(!$usuario){
            return redirect()->to('/login');
        }

        // Pasar los datos del usuario a la vista
        $data = [
           // 'username' => $username,
          'perfil_id'=> $usuario['perfil_id'],
          //'descripcion'
          'nombre'=>$usuario['nombre']
        ];

        // Cargar la vista del panel con los datos del usuario
        echo view('header');
        echo view('panel', $data);
        echo view('bienvenida');
        echo view('footer2',$data);
    }


    // Método para estadísticas (Admin only)
public function estadisticas()
{
    // Verificar que sea admin
    if (session('perfil_id') != 1) {
        return redirect()->to('/panel')->with('msg', 'Acceso denegado');
    }
    
    $db = \Config\Database::connect();
    
    // Productos más vendidos
    $productos_mas_vendidos = $db->query("
        SELECT p.nombre_prod, 
               SUM(dv.cantidad) as total_vendido,
               SUM(dv.cantidad * dv.precio) as total_recaudado
        FROM detalle_venta dv
        JOIN productos p ON dv.id_producto = p.id_producto
        GROUP BY p.id_producto, p.nombre_prod
        ORDER BY total_vendido DESC
        LIMIT 10
    ")->getResultArray();
    
    // Clientes top
    $clientes_top = $db->query("
        SELECT u.nombre, u.apellido,
               COUNT(v.id) as total_compras,
               SUM(v.total_venta) as monto_total
        FROM ventas v
        JOIN usuarios u ON v.id_usuario = u.id_usuario
        GROUP BY u.id_usuario, u.nombre, u.apellido
        ORDER BY monto_total DESC
        LIMIT 10
    ")->getResultArray();
    
    // Totales generales
    $ventas_totales = $db->query("SELECT SUM(total_venta) as total FROM ventas")->getRow()->total ?? 0;
    $total_clientes = $db->query("SELECT COUNT(*) as total FROM usuarios WHERE perfil_id = 2 AND baja = 'NO'")->getRow()->total;
    $total_productos = $db->query("SELECT COUNT(*) as total FROM productos WHERE eliminado = 'NO'")->getRow()->total;
    
    $data = [
        'productos_mas_vendidos' => $productos_mas_vendidos,
        'clientes_top' => $clientes_top,
        'ventas_totales' => $ventas_totales,
        'total_clientes' => $total_clientes,
        'total_productos' => $total_productos
    ];
    
    return view('back/admin/estadisticas_view', $data);
}

// Método para reportes detallados (Admin only)
public function reportes()
{
    // Verificar que sea admin
    if (session('perfil_id') != 1) {
        return redirect()->to('/panel')->with('msg', 'Acceso denegado');
    }
    
    $db = \Config\Database::connect();
    
    // Ventas del período (puedes agregar filtros por fecha)
    $ventas_periodo = $db->query("
        SELECT v.fecha, 
               CONCAT(u.nombre, ' ', u.apellido) as cliente_nombre,
               p.nombre_prod as producto_nombre,
               dv.cantidad,
               dv.precio,
               dv.total
        FROM ventas v
        JOIN usuarios u ON v.id_usuario = u.id_usuario
        JOIN detalle_venta dv ON v.id = dv.id_venta
        JOIN productos p ON dv.id_producto = p.id_producto
        ORDER BY v.fecha DESC
        LIMIT 100
    ")->getResultArray();
    
    $data = [
        'ventas_periodo' => $ventas_periodo
    ];
    
    return view('back/admin/reportes_view', $data);
}
}
