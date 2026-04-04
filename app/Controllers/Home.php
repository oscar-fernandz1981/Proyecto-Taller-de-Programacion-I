<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        
		//$data['titulo']="Multirrubro Blass";
		//$this->load->view('plantilla/header',$data);
		//$this->load->view('navbar');
		$data['titulo']="Multirrubro Blass";		
		echo view('navbar',$data);
		echo view('header',);
		echo view('bienvenida');
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



}
