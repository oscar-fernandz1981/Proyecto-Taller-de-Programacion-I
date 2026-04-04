<?php
namespace App\Controllers;
use App\Models\usuario_Model;
use CodeIgniter\Controller;

class usuario_controller extends Controller{

    public function __construct(){
           helper(['form', 'url']);

    }
    public function create() {
        
         $dato['titulo']='Registro'; 
         echo view('navbar',$dato);   
         echo view('header');
         echo view('registro');
         echo view('footer');
      }
 
    public function formValidation() {
             
        $input = $this->validate([
            'nombre'   => 'required|min_length[3]',
            'apellido' => 'required|min_length[3]|max_length[25]',
            'usuario'  => 'required|min_length[3]',
            'email'    => 'required|min_length[4]|max_length[100]|valid_email|is_unique[usuarios.email]',
            'pass'     => 'required|min_length[3]|max_length[10]'
        ],
        
       );
        $formModel = new usuario_Model();
     
        if (!$input) {
               $data['titulo']='Registro'; 
                echo view('navbar',$data);
                echo view('header');
                echo view('registro', ['validation' => $this->validator]);
                echo view('footer');

        } else {
            $formModel->save([
                'nombre' => $this->request->getVar('nombre'),
                'apellido'=> $this->request->getVar('apellido'),
                'usuario'=> $this->request->getVar('usuario'),
                'email'=> $this->request->getVar('email'),
                'pass' => password_hash($this->request->getVar('pass'), PASSWORD_DEFAULT),
                 //password_hash() crea un nuevo hash de contraseña usando un algoritmo de hash de único sentido.
                 'perfil_id' =>2 //Asigna el perfil de Cliente
             ]);  
             
            // Flashdata funciona solo en redirigir la función en el controlador en la vista de carga.
               session()->setFlashdata('success', 'Usuario registrado con exito');
                return redirect()->to('/registro');
              // return $this->response->redirect('/registro');
      
        }
    }

    public function usuariosEliminados(){
        $userModel = new usuario_Model();
        $baja='SI';
        $data['usuarios'] = $userModel->getUsBaja($baja);
        $dato['titulo']='Usuarios Eliminados'; 
        echo view('header',$dato);
        echo view('panel');
         echo view('back/admin/listUsEliminados_view',$data);
          echo view('footer2');
    }

    public function nuevoUsuario() {
        $data['titulo']='Crear Nuevo Usuario'; 
       echo view('header',$data);
       echo view('panel');
        echo view('back/admin/creoNuevoUsuario_view');
         echo view('footer2');
    
    }


    public function formValidationAdmin() {
        //helper(['form', 'url']);
      
      $input = $this->validate([
          'nombre'   => 'required|min_length[3]',
          'apellido' => 'required|min_length[3]|max_length[25]',
          'email'    => 'required|min_length[4]|max_length[100]|valid_email|is_unique[usuarios.email]',
          'usuario'  => 'required|min_length[3]',
          
          'pass'     => 'required|min_length[3]|max_length[10]',
          'perfil_id'=> 'required|max_length[1]'
          
      ]);
      $formModel = new usuario_Model();
      
      if (!$input) {
             $data['titulo']='Registro'; 
              echo view('header',$data);
              echo view('panel');
              echo view('back/admin/creoNuevoUsuario_view',['validation' => $this->validator]);
              echo view('footer2');
      } else {
          $formModel->save([
              'nombre' => $this->request->getVar('nombre'),
              'apellido' => $this->request->getVar('apellido'),
              'usuario' => $this->request->getVar('usuario'),
              
              'email'  => $this->request->getVar('email'),
              'pass' => password_hash($this->request->getVar('pass'), PASSWORD_DEFAULT),
              'perfil_id'  => $this->request->getVar('perfil_id'),

          ]); 
          session()->setFlashdata('msg','Usuario Creado');
           return redirect()->to(base_url('usuarios-list'));
      }
  }

  /*public function formValidationEdit() {
        
    //print_r($_POST);exit;
    
    $input = $this->validate([
        'nombre'   => 'required|min_length[3]|string',
        'apellido' => 'required|min_length[3]|max_length[25]',
        'email'    => 'required|min_length[4]|max_length[100]|valid_email',
        'usuario'  => 'required|min_length[3]',
        
        'pass'     => 'required|min_length[3]',
        'perfil_id'=> 'required|max_length[1]',
        'baja'  => 'required|max_length[2]'
    ]);
    $Model = new usuario_Model();
    $id=$_POST['id'];
    if (!$input) {
        $data=$Model->getUsuario($id_usuario);
        $dato['titulo']='Editar Usuario'; 
            echo view('header',$dato);
            echo view('nav_view');
            echo view('back/Admin/editarUsuarios_view',compact('data'));
            echo view('footer');
    } else {
        $data=$Model->getUsuario($id_usuario);
        $pass=$data['pass'];
        $hash=$_POST['pass'];
        if($pass == $hash){ 
        $datos=[
            'id' => $_POST['id'],
            'nombre' =>$_POST['nombre'],
            'apellido' => $_POST['apellido'],
            'email' => $_POST['email'],
            'usuario'  => $_POST['usuario'],
           
            'pass' => $_POST['pass'],
            'perfil_id'  => $_POST['perfil_id'],
            'baja'  => $_POST['baja'],
        ];
     }else{
        $datos=[
            'id_usuario' => $_POST['id_usuario'],
            'nombre' =>$_POST['nombre'],
            'apellido' => $_POST['apellido'],
            'email' => $_POST['email'],
            'usuario'  => $_POST['usuario'],
            
            'pass' => password_hash($_POST['pass'],PASSWORD_DEFAULT),
            'perfil_id'  => $_POST['perfil_id'],
            'baja'  => $_POST['baja'],
        ];
     }
     $Model -> update($id_usuario,$datos);

     session()->setFlashdata('msg','Usuario Editado');

     return redirect()->to(base_url('usuarios-list'));
    }
}*/

public function formValidationEdit() {
    $Model = new usuario_Model();
    // 1. Capturamos el ID que viene del campo oculto de la vista
    $id_usuario = $this->request->getVar('id_usuario');

    $input = $this->validate([
        'nombre'   => 'required|min_length[3]',
        'apellido' => 'required|min_length[3]',
        'email'    => 'required|valid_email',
        'usuario'  => 'required',
        'pass'     => 'required',
        'perfil_id'=> 'required',
        'baja'     => 'required'
    ]);

    if (!$input) {
        // Si falla la validación, recargamos la vista con errores
        $data = $Model->getUsuario($id_usuario);
        $dato['titulo'] = 'Editar Usuario'; 
        echo view('header', $dato);
        echo view('panel');
        echo view('back/admin/editarUsuarios_view', compact('data'));
        echo view('footer2');
    } else {
        // 2. Buscamos el usuario actual para comparar la contraseña
        $usuarioActual = $Model->find($id_usuario);
        $passNueva = $this->request->getVar('pass');

        $datos = [
            'nombre'    => $this->request->getVar('nombre'),
            'apellido'  => $this->request->getVar('apellido'),
            'email'     => $this->request->getVar('email'),
            'usuario'   => $this->request->getVar('usuario'),
            'perfil_id' => $this->request->getVar('perfil_id'),
            'baja'      => $this->request->getVar('baja'),
        ];

        // 3. Lógica de Contraseña:
        // Si el admin escribió algo distinto al hash actual, lo encriptamos.
        // Si es igual, significa que no se modificó.
        if ($passNueva !== $usuarioActual['pass']) {
            $datos['pass'] = password_hash($passNueva, PASSWORD_DEFAULT);
        }

        // 4. Actualización usando la clave primaria correcta
        $Model->update($id_usuario, $datos);

        session()->setFlashdata('msg', 'Usuario actualizado correctamente');
        return redirect()->to(base_url('usuarios-list'));
    }
}

public function delete($id_usuario){
    
    $Model=new usuario_Model();
    $data=$Model->getUsuario($id_usuario);
    $datos=[
            'id_usuario' => 'id_usuario',
            'baja'  => 'SI',
            
        ];
    $Model->update($id_usuario,$datos);

    session()->setFlashdata('msg','Usuario Eliminado');

    return redirect()->to(base_url('usuarios-list'));
}

public function habilitar($id_usuario){

    $Model=new usuario_Model();
    $data=$Model->getUsuario($id_usuario);
    $datos=[
            'id_usurio' => 'id_usuario',
            'baja'  => 'NO',
            
        ];
    $Model->update($id_usuario,$datos);

    session()->setFlashdata('msg','Usuario Habilitado');

    return redirect()->to(base_url('eliminados'));
}




public function usuarioEdit() {
        
    //print_r($_POST);exit;
    
    $input = $this->validate([
        'nombre'   => 'required|min_length[3]',
        'apellido' => 'required|min_length[3]|max_length[25]',
        'email'    => 'required|min_length[4]|max_length[100]|valid_email',
        'usuario'  => 'required|min_length[3]',
       
        'pass'     => 'required|min_length[3]'
    ]);
    $Model = new Usuarios_model();
    $id=$_POST['id_usuario'];
    if (!$input) {
        $data=$Model->getUsuario($id);
        $dato['titulo']='Editar Usuario'; 
            echo view('header',$dato);
            echo view('panel');
            echo view('back/usuario/editoMisDatos_view',compact('data'));
            echo view('footer2');
    } else {
        $data=$Model->getUsuario($id);
        $pass=$data['pass'];
        $hash=$_POST['pass'];
        if($pass == $hash){ 
        $datos=[
            'id' => $_POST['id'],
            'nombre' =>$_POST['nombre'],
            'apellido' => $_POST['apellido'],
            'email' => $_POST['email'],
            'usuario'  => $_POST['usuario'],
            
            'pass' => $_POST['pass'],
            
        ];
     }else{
        $datos=[
            'id' => $_POST['id'],
            'nombre' =>$_POST['nombre'],
            'apellido' => $_POST['apellido'],
            'email' => $_POST['email'],
            'usuario'  => $_POST['usuario'],
            
            'pass' => password_hash($_POST['pass'],PASSWORD_DEFAULT),
            
        ];
     } 
     
     
     $Model -> update($id,$datos);

     session()->setFlashdata('msg','Datos Editados con Éxito');

     return redirect()->to(base_url('/'));
    }
}



}
