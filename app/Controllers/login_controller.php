<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\usuario_Model;

// Si estás usando CodeIgniter 4 y tienes un BaseController, esto está bien.
class login_controller extends BaseController 
{
    public function index()
    {
        helper(['form','url']);
        
        $dato['titulo']='Login';
        
        // Asumo que estas son tus vistas
        echo view('header',$dato); 
        echo view('navbar');
        echo view('back/usuario/login');
        echo view('footer');
    }

    public function auth()
    {
        $session = session();
        $model = new usuario_Model();

        // Traemos los datos del formulario
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('pass');
        
        $data = $model->where('email', $email)->first(); 
        
        if($data){
            $pass_hash = $data['pass']; // Contraseña hasheada de la BD
            $ba = $data['baja'];
            
            if ($ba == 'SI'){
                $session->setFlashdata('msg', 'Usuario dado de baja');
                return redirect()->to('/login');
            }
            
            // Se verifica la contraseña
            $verify_pass = password_verify($password, $pass_hash);

            if($verify_pass){
                $ses_data = [
                    'id_usuario' => $data['id_usuario'],
                    'nombre' => $data['nombre'],
                    'apellido'=> $data['apellido'],
                    'email' =>  $data['email'],
                    'usuario' => $data['usuario'],
                    'perfil_id'=> $data['perfil_id'],
                    'isLoggedIn'=>TRUE
                ];
                
                // Si se cumple la verificación inicia la sesión  
                $session->set($ses_data);
                session()->setFlashdata('msg', 'Bienvenido!!');
                
                // CORRECCIÓN CLAVE: Redirige a ambos al panel principal.
                // La vista cargada por el Panel_controller se encargará de mostrar el contenido del Admin o Cliente.
                return redirect()->to('/panel'); 
                
            } else {  
                // Password incorrecta
                $session->setFlashdata('msg', 'Password Incorrecta');
                return redirect()->to('/login');
            }
        } else {
            // Email no encontrado
            $session->setFlashdata('msg', 'No Existe el Email o es Incorrecto');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/'); 
    }
}