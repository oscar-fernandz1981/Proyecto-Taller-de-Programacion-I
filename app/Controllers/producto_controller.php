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
                echo view('footer2');
	}

	public function ProductoValidation() {
          //helper(['form', 'url']);
        
        $input = $this->validate([
            'nombre'   => 'required|min_length[3]',
            'descripcion'   => 'required',
            'categoria_id' => 'required|min_length[1]|max_length[20]',
            'precio'    => 'required|min_length[2]|max_length[10]',
            'precio_vta'  => 'required|min_length[2]',
            'stock'     => 'required|min_length[1]|max_length[10]',
            'stock_min'     => 'required|min_length[1]|max_length[10]',
            
            
        ]);
        $ProductoModel = new producto_Model();
        
        if (!$input) {
               $data['titulo']='Nuevo Producto'; 
                echo view('header',$data);
                echo view('panel');
                echo view('back/admin/ProductoNuevo_view',['validation' => $this->validator]);
                echo view('footer2');
        } else {

        	$img = $this->request->getFile('imagen');
        	$nombre_aleatorio= $img->getRandomName();
        	$img->move(ROOTPATH.'assets/uploads',$nombre_aleatorio);

            $ProductoModel->save([
                'nombre_prod' => $this->request->getVar('nombre'),
                'descripcion' => $this->request->getVar('descripcion'),
                'imagen' => $img->getName(),
                'categoria_id' => $this->request->getVar('categoria_id'),
                'precio' => $this->request->getVar('precio'),
                'precio_vta'  => $this->request->getVar('precio_vta'),
                'stock' => $this->request->getVar('stock'),
                'stock_min' => $this->request->getVar('stock_min'),
                'eliminado' => 'NO',
                
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
        echo view('footer2');
       
    } 

	public function ProductosDisp(){
        $ProductosModel = new producto_Model();
        $eliminado='NO';
        $data['productos'] = $ProductosModel->getProdBaja($eliminado);
        $dato['titulo']='Productos Disponibles'; 
        
        echo view('header',$dato);
        echo view('panel');
         echo view('back/carrito/ProductosCart_view', $data);
          echo view('footer2');
       
    }

    public function getProductoEdit($id_producto){
    	$Model = new producto_Model();
    	$data=$Model->getProducto($id_producto);
            $dato['titulo']='Editar Producto'; 
                echo view('header',$dato);
                echo view('panel');
                echo view('back/admin/editarProducto_view',compact('data'));
                echo view('footer2');
    }

    public function ProductoDetalle($id_producto){
    	$Model = new producto_Model();
    	$data=$Model->getProducto($id_producto);
            $dato['titulo']='Editar Producto'; 
                echo view('header',$dato);
                echo view('panel');
                echo view('back/carrito/DetalleProducto_view',compact('data'));
                echo view('footer2');
    }

    public function ProdValidationEdit() {
        
        //print_r($_POST);exit;
        
        $input = $this->validate([
            'nombre'   => 'required|min_length[3]',
           
            'categoria_id' => 'required|min_length[1]|max_length[2]',
            'precio'    => 'required|min_length[2]|max_length[10]',
            'precio_vta'  => 'required|min_length[2]',
            'stock'     => 'required|min_length[1]|max_length[10]',
            'stock_min'     => 'required|min_length[1]|max_length[10]',
            'eliminado' => 'required|min_length[2]|max_length[2]',
        ]);
        $Model = new producto_Model();
        $id=$_POST['id_producto'];
        if (!$input) {
            $data=$Model->getProducto($id_producto);
            $dato['titulo']='Editar Producto'; 
                echo view('header',$dato);
                echo view('panel');
                echo view('back/admin/editarProducto_view',compact('data'));
                echo view('footer2');
        } else {
        	$validation= $this->validate([
        		'image' => ['uploaded[imagen]',
        		'mime_in[imagen,image/jpg,image/jpeg,image/png]',
        	]
        	]);
        	if($validation){
        	$img = $this->request->getFile('imagen');
        	$nombre_aleatorio= $img->getRandomName();
        	$img->move(ROOTPATH.'assets/uploads',$nombre_aleatorio);

            $datos=[
                'id_producto' => $_POST['id_producto'],
                'nombre_prod' =>$_POST['nombre'],  // El input se llama 'nombre', la columna 'nombre_prod'
                'descripcion' => $_POST['descripcion'],
                'imagen' => $img->getName(),
                'precio' => $_POST['precio'],
                'precio_vta'  => $_POST['precio_vta'],
                'categoria_id'  => $_POST['categoria_id'],
                'stock'  => $_POST['stock'],
                'stock_min'  => $_POST['stock_min'],
                'eliminado' => $_POST['eliminado'],
                
            ];  
         	}else{
         	$datos=[
                'id_producto' => $_POST['id_producto'],
                'nombre_prod' =>$_POST['nombre'],
                
                'precio' => $_POST['precio'],
                'precio_vta'  => $_POST['precio_vta'],
                'categoria_id'  => $_POST['categoria_id'],
                'stock'  => $_POST['stock'],
                'stock_min'  => $_POST['stock_min'],
                'eliminado' => $_POST['eliminado'],
                
            ];
            }
         
         $Model -> updateDatosProd($id,$datos);

         session()->setFlashdata('msg','Producto Editado');

         return redirect()->to(base_url('Lista_Productos'));
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
        echo view('footer2');
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
}