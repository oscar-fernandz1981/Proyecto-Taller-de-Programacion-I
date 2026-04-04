<?php
namespace App\Controllers;
use App\Models\producto_Model;
use App\Models\usuario_Model;
use App\Models\ventas_cabecera_Model;
use App\Models\ventas_detalle_Model;
use CodeIgniter\Controller;

class Producto_controller extends Controller{

	public function __construct(){
           helper(['form', 'url']);

	}

	public function nuevoProducto(){

		$data['titulo']='Nuevo Producto'; 
                echo view('header',$data);
                echo view('panel');
                echo view('back/admin/ProductoNuevo_view');
                echo view('footer');
	}

	public function ProductoValidation() {
    // 1. Mantenemos tus reglas actuales
    $input = $this->validate([
        'nombre'       => 'required|min_length[3]',
        'descripcion'  => 'required',
        'categoria_id' => 'required',
        'precio'       => 'required',
        'precio_vta'   => 'required',
        'stock'        => 'required',
        'stock_min'    => 'required',
        // Agregamos las nuevas sin quitar las anteriores
        'promo_activada'       => 'permit_empty', 
        'descuento_porcentaje' => 'permit_empty'
    ]);

    $ProductoModel = new producto_Model();

    if (!$input) {
        // ... (tu código de retorno por error se mantiene igual)
    } else {
        // 2. Tu lógica de imagen se queda exactamente como está (funciona perfecto)
        $img = $this->request->getFile('imagen');
        $nombre_aleatorio = $img->getRandomName();
        $img->move(ROOTPATH.'assets/uploads', $nombre_aleatorio);

        // 3. Guardado: Usamos getVar con valores default por si el form falla en enviarlos
        $ProductoModel->save([
            'nombre_prod'  => $this->request->getVar('nombre'),
            'descripcion'  => $this->request->getVar('descripcion'),
            'imagen'       => $img->getName(),
            'categoria_id' => $this->request->getVar('categoria_id'),
            'precio'       => $this->request->getVar('precio'),
            'precio_vta'   => $this->request->getVar('precio_vta'),
            'stock'        => $this->request->getVar('stock'),
            'stock_min'    => $this->request->getVar('stock_min'),
            'eliminado'    => 'NO',
            
            // Usamos un operador ternario simple para asegurar que si no vienen, sean 0
            'promo_activada'       => $this->request->getVar('promo_activada') ?? 0,
            'descuento_porcentaje' => $this->request->getVar('descuento_porcentaje') ?? 0,
        ]);

        session()->setFlashdata('msg','Producto Creado con Éxito!');
        return redirect()->to(base_url('Lista_Productos'));
    }
}

    public function ListaProductos(){
        $ProductosModel = new producto_Model();
        $eliminado='NO';
        $data['productos'] = $ProductosModel->getProdBaja($eliminado);
        $dato['titulo']='Lista de Productos'; 
        
        
        echo view('header',$dato);
        echo view('panel');
        echo view('back/admin/productos_view', $data);
        echo view('footer');
       
    } 

public function ProductosDisp(){
    $ProductosModel = new producto_Model();
    $eliminado = 'NO';
    
    // Capturamos la búsqueda (si existe)
    $busqueda = $this->request->getGet('q'); 

    if (!empty($busqueda)) {
        // FLUJO A: El usuario usó el buscador
        $data['productos'] = $ProductosModel->where('eliminado', $eliminado)
            ->groupStart()
                ->like('nombre_prod', $busqueda)
                ->orLike('categoria_id', $this->mapearCategoria($busqueda)) 
            ->groupEnd()
            ->findAll();
        
        $dato['titulo'] = 'Resultados para: "' . $busqueda . '"';
    } else {
        // FLUJO B: Es una carga normal del catálogo (no rompe nada)
        $data['productos'] = $ProductosModel->getProdBaja($eliminado);
        $dato['titulo'] = 'Productos Disponibles'; 
    }

    // IMPORTANTE: Eliminamos las líneas que estaban aquí abajo y que 
    // hacían que $data['productos'] volviera a cargarse siempre.

    echo view('header', $dato);
    echo view('panel');
    echo view('back/carrito/ProductosCart_view', $data);
    echo view('footer');
}


    // Función auxiliar para que también busque por el nombre de la categoría
private function mapearCategoria($busqueda) {
    $busqueda = strtolower($busqueda);
    if (strpos('termos', $busqueda) !== false) return 1;
    if (strpos('auriculares', $busqueda) !== false || strpos('tech', $busqueda) !== false) return 2;
    if (strpos('juguetes', $busqueda) !== false || strpos('regaleria', $busqueda) !== false) return 3;
    return $busqueda; // Si no coincide, devuelve el texto original
}


    public function getProductoEdit($id_producto){
    	$Model = new producto_Model();
    	$data=$Model->getProducto($id_producto);
            $dato['titulo']='Editar Producto'; 
                echo view('header',$dato);
                echo view('panel');
                echo view('back/admin/editarProducto_view',compact('data'));
                echo view('footer');
    }

public function ProductoDetalle($id_producto){
    $Model = new producto_Model();
    $data = $Model->getProducto($id_producto);
    
    // Capturamos si viene de "promo" o no
    $dato['fuente'] = $this->request->getGet('from'); 
    
    $dato['titulo'] = 'Detalle del Producto'; // Corregí el título de "Editar" a "Detalle"
    
    echo view('header', $dato);
    echo view('panel');
    echo view('back/carrito/DetalleProducto_view', [
        'data' => $data, 
        'fuente' => $dato['fuente'] // Pasamos la fuente a la vista
    ]);
    echo view('footer');
}
    public function ProdValidationEdit() {
        $Model = new producto_Model();
        $id = $this->request->getVar('id_producto');

        $reglas = [
            'nombre'       => 'required|min_length[3]|trim',
            'categoria_id' => 'required',
            'precio'       => 'required|decimal|greater_than[0]',
            'precio_vta'   => 'required|decimal|greater_than[0]',
            'stock'        => 'required|is_natural',
            'stock_min'    => 'required|is_natural|greater_than[0]',
            'promo_activada'       => 'required|integer',
            'descuento_porcentaje' => 'required|is_natural|less_than_equal_to[100]',
        ];

        $mensajes = [
            'nombre' => [
                'required'   => 'El nombre del producto es obligatorio.',
                'min_length' => 'El nombre debe tener al menos 3 caracteres.',
            ],
            'precio' => [
                'required'     => 'El precio es obligatorio.',
                'decimal'      => 'Ingrese un formato decimal válido.',
                'greater_than' => 'El precio debe ser un valor mayor a cero.'
            ],
            'precio_vta' => [
                'required'     => 'El precio de venta es obligatorio.',
                'decimal'      => 'Ingrese un formato decimal válido.',
                'greater_than' => 'El precio de venta debe ser un valor mayor a cero.'
            ],
            'stock' => [
                'required'   => 'El stock es obligatorio.',
                'is_natural' => 'El stock debe ser un número entero (0 o más).'
            ],
            'stock_min' => [
                'required'     => 'El stock mínimo es obligatorio.',
                'is_natural'   => 'Debe ser un número entero.',
                'greater_than' => 'El stock mínimo debe ser al menos 1.'
            ],
            'categoria_id' => [
                'required' => 'Seleccione una categoría.'
            ]
        ];

        if (!$this->validate($reglas, $mensajes)) {
            $data = $Model->getProducto($id);
            $dato['titulo'] = 'Editar Producto';
            
            echo view('header', $dato);
            echo view('panel');
            echo view('back/admin/editarProducto_view', [
                'data' => $data, 
                'validation' => $this->validator
            ]);
            echo view('footer');
        } else {
            // AQUÍ ESTÁ LA CORRECCIÓN: La lógica real de guardado
            $img = $this->request->getFile('imagen');
            
            $datos = [
                'nombre_prod'  => $this->request->getVar('nombre'),
                'precio'       => $this->request->getVar('precio'),
                'precio_vta'   => $this->request->getVar('precio_vta'),
                'categoria_id' => $this->request->getVar('categoria_id'),
                'stock'        => $this->request->getVar('stock'),
                'stock_min'    => $this->request->getVar('stock_min'),
                'promo_activada'       => $this->request->getVar('promo_activada'),
                'descuento_porcentaje' => $this->request->getVar('descuento_porcentaje'),
            ];

            // Si el usuario subió una imagen nueva, la procesamos
            if ($img && $img->isValid() && !$img->hasMoved()) {
                $newName = $img->getRandomName();
                $img->move(ROOTPATH . 'assets/uploads', $newName);
                $datos['imagen'] = $newName;
            }

            // Usamos el modelo para actualizar los datos
            $Model->update($id, $datos);
            session()->setFlashdata('success', '¡Producto editado satisfactoriamente!');
            return redirect()->to(base_url('Lista_Productos'));
            //return redirect()->to(base_url('Lista_Productos'))->with('success', 'Producto actualizado correctamente');
        }
    }
    public function deleteProd($id_producto){
    
        $Model=new producto_Model();
        $data=$Model->getProducto($id_producto);
        $datos=[
                'id_producto' => 'id_producto',
                'eliminado'  => 'SI',
                
            ];
        $Model->update($id_producto,$datos);

        session()->setFlashdata('msg','Producto Eliminado');

        return redirect()->to(base_url('Lista_Productos'));
    }

    public function ListaProductosElim(){
        $userModel = new producto_Model();
        $eliminado='SI';
        $data['productos'] = $userModel->getProdBaja($eliminado);
        $dato['titulo']='Productos Eliminados'; 
        echo view('header',$dato);
        echo view('panel');
        echo view('back/Admin/listProd_Eliminados_view',$data);
        echo view('footer');
    }

    public function habilitarProd($id_producto){
    
        $Model=new producto_Model();
        $data=$Model->getProducto($id_producto);
        $datos=[
                'id_producto' => 'id_producto',
                'eliminado'  => 'NO',
                
            ];
        $Model->update($id_producto,$datos);

        session()->setFlashdata('msg','Producto Habilitado');

        return redirect()->to(base_url('eliminadosProd'));
    }




    public function ListaPromociones() {
    $ProductosModel = new producto_Model();
    
    // Filtramos: No eliminados Y con promo activada
    $data['productos'] = $ProductosModel->where('eliminado', 'NO')
                                        ->where('promo_activada', 1)
                                        ->findAll();
                                        
    $dato['titulo'] = 'Listado de Ofertas'; 
    
    echo view('header', $dato);
    echo view('panel');
    // Usamos la vista que mencionaste
    echo view('back/admin/promociones_view', $data);
    echo view('footer');
}



    public function ProductosEnOferta(){
        $ProductosModel = new producto_Model();
        
        // Filtramos solo los productos con promoción activa y que no estén eliminados
        $data['productos'] = $ProductosModel->where('promo_activada', 1)
                                            ->where('eliminado', 'NO')
                                            ->findAll();
                                            
        $dato['titulo'] = 'Ofertas del Mes'; 
        
        echo view('header', $dato);
        echo view('panel'); // Mantengo tu estructura de panel
        echo view('back/carrito/ProductosCart_view', $data); // Reutilizamos la vista
        echo view('footer');
    }




    public function catalogo_filtro($id) {
    $model = new \App\Models\producto_Model();
    
    // Filtramos por el ID de categoría que viene en la URL
    $data['productos'] = $model->where([
        'categoria_id' => $id, 
        'eliminado' => 'NO'
    ])->findAll();

    // Definimos el título dinámico según la categoría
    $titulos = [
        1 => 'Línea Termos',
        2 => 'Auriculares y Tech',
        3 => 'Regalería y Juguetes'
    ];
    
    $data['titulo'] = $titulos[$id] ?? 'Nuestro Catálogo';

    echo view('header', $data);
    echo view('navbar', $data);
    echo view('back/carrito/catalogo_filtrado', $data); // Nombre de la nueva vista
    echo view('footer');
}




}