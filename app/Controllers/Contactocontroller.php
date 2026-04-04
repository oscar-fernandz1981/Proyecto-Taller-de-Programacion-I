<?php

namespace App\Controllers;
use App\Models\FormModel;
use CodeIgniter\Controller;

class Contactocontroller extends BaseController
{
    public function index()
    {
    	echo view('header');
    	echo view('panel');
         echo view('contacto');
          echo view('footer');
    }

    
    // Show consultas list
    public function Datos_consultas(){
    $consulModel = new FormModel();
    $estado = 'Pendiente';
    
    // Obtenemos las consultas pendientes
    $data['consultas'] = $consulModel->getConsultas($estado);
    $data['titulo'] = 'Consultas Pendientes'; 
    
    echo view('header', $data);
    echo view('panel');
    // Esta es la vista que vamos a crear/ajustar ahora:
    echo view('back/admin/consultas_view', $data); 
    echo view('footer');
}

    public function ConsultaDetalle($id){
      $Model = new FormModel();
      $data=$Model->getConsulta($id);
            $dato['titulo']='Detalle Consulta'; 
                echo view('header',$dato);
                echo view('panel');
                echo view('back/usuario/DetalleConsulta_view',compact('data'));
                echo view('footer');
    }

    public function deleteConsulta($id){
    
        $Model=new FormModel();
        $data=$Model->getConsulta($id);
        $datos=[
                'id' => 'id',
                'estado'  => 'Resuelta',
                
            ];
        $Model->update($id,$datos);

        session()->setFlashdata('msg','Consulta Resuelta');

        return redirect()->to(base_url('consultas'));
    }

    public function habilitarConsulta($id){
    
        $Model=new FormModel();
        $data=$Model->getConsulta($id);
        $datos=[
                'id' => 'id',
                'estado'  => 'Pendiente',
                
            ];
        $Model->update($id,$datos);

        session()->setFlashdata('msg','Consulta Habilitada Nuevamente');

        return redirect()->to(base_url('consultasResueltas'));
    }

    public function Datos_consultasResueltas(){
        $consulModel = new FormModel();
        $estado = 'Resuelta';
        $data['consultas'] = $consulModel->getConsultas($estado);
        $dato['titulo']='Listado de Consultas';
        
        echo view('header',$dato);
        echo view('panel');
         echo view('back/usuario/consultasResueltas_view', $data);
          echo view('footer');
       
    }


     public function contacto()
    {
        helper(['form','url']);
        
        $dato['titulo'] = 'Contacto / Consultas';
        
        // Cargar vistas según tu estructura
        echo view('header', $dato);
        echo view('panel');  // Cambia por 'navbar' si prefieres
        echo view('back/usuario/contact_form');
        echo view('footer');
    }
    
    public function submit()
    {
        $session = session();
        $validation = \Config\Services::validation();
        
        // Reglas de validación
        $rules = [
            'nombre' => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'asunto' => 'required',
            'mensaje' => 'required|min_length[10]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()
                            ->withInput()
                            ->with('errors', $validation->getErrors());
        }
        
        // Guardar la consulta en la base de datos
        $consulModel = new FormModel();
        
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'email' => $this->request->getPost('email'),
            'asunto' => $this->request->getPost('asunto'),
            'mensaje' => $this->request->getPost('mensaje'),
            
            //'fecha' => date('Y-m-d H:i:s'),
            'estado' => 'Pendiente',
        ];
        
        // Si el usuario está logueado, agregar su ID
        if ($session->get('id_usuario')) {
            $data['id_usuario'] = $session->get('id_usuario');
        }
        
        $consulModel->insert($data);
        
        $session->setFlashdata('msg', '¡Consulta enviada con éxito! Te responderemos pronto.');
        return redirect()->to('contacto');
    }
	
 }