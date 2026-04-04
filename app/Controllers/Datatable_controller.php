<?php 
namespace App\Controllers;
use App\Models\usuario_Model;
use CodeIgniter\Controller;

class Datatable_controller extends Controller
{
    // muestro la lista de usuarios: usuarios-list
    public function index(){
        $userModel = new usuario_Model();
        $baja='NO';
        $data['usuarios'] = $userModel->getUsBaja($baja);
        $dato['titulo']='Lista de Usuarios'; 
        
        echo view('header',$dato);
        echo view('panel');
        echo view('back/usuario/usuarios_view', $data);
        echo view('footer');
       
    } 

    public function editar($id_usuario){

        $userModel=new usuario_Model();
        $data=$userModel->getUsuario($id_usuario);
        $dato['titulo']='Editar Usuario';
        echo view('header',$dato);
        echo view('panel');
         echo view('back/admin/editarUsuarios_view',compact('data'));
          echo view('footer');
       
   }

   public function editoMisDatos() {
    $session = session();
    $id_usuario = $session->get('id_usuario'); // Obtenemos el ID del logueado

    $userModel = new usuario_Model();
    $data = $userModel->getUsuario($id_usuario);
    
    $dato['titulo'] = 'Editar mis Datos';
    echo view('header', $dato);
    echo view('panel');
    echo view('back/usuario/editoMisDatos_view', compact('data'));
    echo view('footer');
}
       
   }

