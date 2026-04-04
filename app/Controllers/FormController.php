<?php 
namespace App\Controllers;
use App\Models\FormModel;
use CodeIgniter\Controller;

class FormController extends Controller
{
    // Carga la vista del formulario
    public function create() {
        $dato['titulo'] = 'Contacto';
        
        echo view('header', $dato);
        echo view('panel');
        echo view('back/usuario/contact_form');
        echo view('footer');
    }

    // Procesa la validación y el guardado
    public function formValidation() {
        helper(['form', 'url']);

        // 1. Definimos las reglas de validación
        $reglas = [
            'nombre' => [
                'rules'  => 'required|min_length[3]|max_length[25]',
                'errors' => [
                    'required'   => 'El campo Nombre no está completo.',
                    'min_length' => 'El nombre debe tener al menos 3 caracteres.',
                    'max_length' => 'El nombre no puede superar los 25 caracteres.'
                ]
            ],
            'email' => [
                'rules'  => 'required|valid_email',
                'errors' => [
                    'required'    => 'El campo email no está completo.',
                    'valid_email' => 'Debes ingresar un formato de email válido.'
                ]
            ],

            'asunto' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Debe seleccionar un motivo para su consulta.'
                ]
            ],
            'mensaje' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'El mensaje no puede estar vacío.'
                ]
            ]
        ];

        // 2. Ejecutamos la validación
        if (!$this->validate($reglas)) {

            return redirect()->back()->withInput()->with('validation', $this->validator);
            /* Obtenemos los errores como un array de strings ['nombre' => 'mensaje...']
                    $mensajesDeError = $this->validator->getErrors();
    
                    return redirect()->back()
                     ->withInput()
                     ->with('errores', $mensajesDeError);*/
        }

        // 3. SI PASA: Guardamos en la base de datos
        $formModel = new FormModel();
        
        $data = [
            'nombre'  => $this->request->getVar('nombre'),
            'email'   => $this->request->getVar('email'),
            'mensaje' => $this->request->getVar('mensaje'),
            'asunto'  => $this->request->getVar('asunto') ?? 'Consulta General',
            'estado'  => 'Pendiente'
        ];

        $formModel->save($data);

        // 4. Mensaje de éxito y redirección
        session()->setFlashdata('msg', '¡Mensaje enviado con éxito! Nos comunicaremos pronto.');
        return redirect()->to(base_url('contacto'));
    }
}