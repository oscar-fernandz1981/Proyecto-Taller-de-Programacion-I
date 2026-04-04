<?php

namespace App\Controllers;
use App\Models\producto_Model;

class Home extends BaseController
{
   public function index()
    {
        $prodModel = new producto_Model();
        $db = \Config\Database::connect();

        // 1. OBTENER NOVEDADES
        $novedades = $prodModel->where('eliminado', 'NO')
                               ->orderBy('id_producto', 'DESC')
                               ->findAll(4);

        // 2. MÁS VENDIDOS (Lógica Real)
        $builder = $db->table('ventas_detalle vd');
        $builder->select('p.*, SUM(vd.cantidad) as total_vendido');
        $builder->join('productos p', 'p.id_producto = vd.producto_id');
        $builder->where('p.eliminado', 'NO');
        $builder->groupBy('vd.producto_id');
        $builder->orderBy('total_vendido', 'DESC');
    
        // 3. PREPARAR EL ARRAY DATA (Aquí estaba el lío)
        $data['titulo'] = "Multirrubro Blass";
        $data['novedades'] = $novedades; 
        // Ejecutamos la query y guardamos el resultado directamente en el array
        $data['mas_vendidos'] = $builder->get(4)->getResultArray();

        // 4. PASAR $data A LAS VISTAS (Fundamental para que no diga "Undefined variable")
        echo view('header', $data);
        echo view('navbar', $data);
        echo view('bienvenida', $data); // <--- IMPORTANTE pasarle $data aquí
        echo view('footer');
    }




    public function somos(){
		
		$data['titulo']="Somos";
		echo view('navbar',$data);
		echo view('header');
		echo view('somos');
		echo view('footer');
	}
	
	public function productos(){
		
		$data['titulo']="Nuestros Productos";
		echo view('navbar',$data);
		echo view('header');
		echo view('productos');
		echo view('footer');
	}


	public function promociones(){
		
		$data['titulo']="Comercializacion-Ventas";
		echo view('navbar',$data);
		echo view('header');
		echo view('promociones');
		echo view('footer');
	}
	
	
	public function contacto(){
		
		$data['titulo']="Consultas";
		echo view('navbar',$data);
		echo view('header');
		echo view('contacto');
		echo view('footer');
	}

	public function condiciones(){
		
		$data['titulo']="Condiciones y Términos de Uso";
		echo view('navbar',$data);
		echo view('header');
		echo view('condiciones');
		echo view('footer');
	}

	public function registro(){
		
		$data['titulo']="Registro";
		echo view('navbar',$data);
		echo view('header');
		echo view('registro');
		echo view('footer');
	}


		public function promoVisita() {
		$model = new \App\Models\producto_Model();
		
		// Traemos TODOS los productos en oferta que no estén eliminados
		$data['ofertas'] = $model->where([
			'promo_activada' => 1, 
			'eliminado' => 'NO'
		])->findAll();

		$data['titulo'] = 'Ofertas Exclusivas'; // Cambié a $data para ser consistente
		
		echo view('header', $data);
		echo view('navbar', $data);
		echo view('promociones', $data); 
		echo view('footer');
	}


	public function comercializacion()
{
    $data['titulo'] = "Formas de Comercialización";
    echo view('header', $data);
    echo view('navbar', $data);
    echo view('comercializacion'); // Esta es la vista que crearemos
    echo view('footer');
}



}
