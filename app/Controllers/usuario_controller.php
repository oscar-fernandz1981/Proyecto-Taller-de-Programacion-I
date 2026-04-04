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
    // Definimos las reglas
    $rules = [
        'nombre'   => 'required|min_length[3]',
        'apellido' => 'required|min_length[3]|max_length[25]',
        'usuario'  => 'required|min_length[3]',
        'email'    => 'required|min_length[4]|max_length[100]|valid_email|is_unique[usuarios.email]',
        'pass'     => 'required|min_length[3]|max_length[10]'
    ];

    // Definimos los mensajes personalizados en ESPAÑOL
    $errors = [
        'nombre' => [
            'required'   => 'El nombre es obligatorio.',
            'min_length' => 'El nombre debe tener al menos 3 caracteres.'
        ],
        'apellido' => [
            'required'   => 'El apellido es obligatorio.',
            'min_length' => 'El apellido debe tener al menos 3 caracteres.'
        ],
        'email' => [
            'required'    => 'El email es obligatorio.',
            'valid_email' => 'El formato de email no es válido.',
            'is_unique'   => 'Este email ya está registrado.'
        ],
        'pass' => [
            'required'   => 'La contraseña es obligatoria.',
            'min_length' => 'La contraseña debe tener al menos 3 caracteres.'
        ]
    ];

    // Pasamos las reglas y los mensajes juntos
    $input = $this->validate($rules, $errors);

    $formModel = new usuario_Model();

    if (!$input) {
        $data['titulo'] = 'Registro'; 
        echo view('navbar', $data);
        echo view('header');
        echo view('registro', ['validation' => $this->validator]);
        echo view('footer');
    } else {
        // ... (el resto de tu código de guardado sigue igual)
        $formModel->save([
            'nombre'   => $this->request->getVar('nombre'),
            'apellido' => $this->request->getVar('apellido'),
            'usuario'  => $this->request->getVar('usuario'),
            'email'    => $this->request->getVar('email'),
            'pass'     => password_hash($this->request->getVar('pass'), PASSWORD_DEFAULT),
            'perfil_id' => 2 
        ]); 
        
        session()->setFlashdata('success', 'Usuario registrado con éxito');
        return redirect()->to('/registro');
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
          echo view('footer');
    }

    public function nuevoUsuario() {
        $data['titulo']='Crear Nuevo Usuario'; 
       echo view('header',$data);
       echo view('panel');
        echo view('back/admin/creoNuevoUsuario_view');
         echo view('footer');
    
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
              echo view('footer');
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
        echo view('footer');
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
    $Model = new usuario_Model();
    $datos = [
        'baja' => 'SI', // El ID no hace falta actualizarlo en el array si ya lo pasas en el update
    ];
    $Model->update($id_usuario, $datos);
    session()->setFlashdata('msg','Usuario Eliminado');
    return redirect()->to(base_url('usuarios-list'));
}

public function habilitar($id_usuario){
    $Model = new usuario_Model();
    $datos = [
        'baja' => 'NO',
    ];
    $Model->update($id_usuario, $datos);
    session()->setFlashdata('msg','Usuario Habilitado');
    return redirect()->to(base_url('eliminados'));
}


public function usuarioEdit() {
    $Model = new usuario_Model();
    $id = $this->request->getVar('id_usuario');

    $rules = [
        'nombre'   => 'required|min_length[3]',
        'apellido' => 'required|min_length[3]',
        'email'    => 'required|valid_email',
        'usuario'  => 'required|min_length[3]',
        'dni'      => 'required|numeric|exact_length[8]', // Asegurado en 8
        'pass'     => 'permit_empty|min_length[3]'
    ];

    if (!$this->validate($rules)) {
        $data = $Model->getUsuario($id);
        $dato['titulo'] = 'Editar mis Datos';
        echo view('header', $dato);
        echo view('panel');
        echo view('back/usuario/editoMisDatos_view', ['data' => $data, 'validation' => $this->validator]);
        echo view('footer');
    } else {
        $datos = [
            'nombre'   => $this->request->getVar('nombre'),
            'apellido' => $this->request->getVar('apellido'),
            'email'    => $this->request->getVar('email'),
            'usuario'  => $this->request->getVar('usuario'),
            'dni'      => $this->request->getVar('dni'),
        ];

        $passNueva = $this->request->getVar('pass');
        if (!empty($passNueva)) {
            $datos['pass'] = password_hash($passNueva, PASSWORD_DEFAULT);
        }

        // SOLO UNA VEZ: Lógica de la imagen
        $file = $this->request->getFile('perfil_img');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();

            // La guardamos en la carpeta raíz de uploads, igual que los productos
            $file->move(ROOTPATH . 'assets/uploads/', $newName);
            $datos['perfil_img'] = $newName; 
        }

        if ($Model->update($id, $datos)) {
            session()->setFlashdata('msg', '¡Perfil actualizado con éxito!');
        } else {
            session()->setFlashdata('fail', 'Error al actualizar los datos');
        }
        return redirect()->to(base_url('miPerfil'));
    }
}


public function editarMiPerfil() {
    $session = session();
    $model = new usuario_Model();
    // Buscamos los datos frescos de la base de datos
    $data['data'] = $model->find($session->get('id_usuario')); 
    
    $dato['titulo'] = 'Editar mi Perfil';
    echo view('header', $dato);
    echo view('panel');
    echo view('back/usuario/editoMisDatos_view', $data);
    echo view('footer');
}

}
