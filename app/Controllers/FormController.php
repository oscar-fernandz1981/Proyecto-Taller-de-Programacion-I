<?php 
namespace App\Controllers;
use App\Models\FormModel;
use CodeIgniter\Controller;
use App\Models\usuario_Model;

class FormController extends Controller
{
    public function create() {

        $dato['titulo']='Contacto';
        echo view('header',$dato);
        echo view('panel');
        echo view('back/usuario/contact_form');
        echo view('footer2');
    }
 
    public function formValidation() {
        helper(['form', 'url']);
        
        
        $input = $this->validate([
            'nombre' =>[
                'rules'=>'required|min_length[3]|max_length[25]',
                'errors'=>[
                 'required' => 'El campo Nombre no esta completo',
                 'min_length'=>'El campo Nombre solo acepta un minimo de 3 caracteres',
                 'max_length'=>'El campo Nombre solo acepta un maximo de 25 caracteres',
                ]
                ],
            'email' =>[
                'rules'=>'required|valid_email',
                'errors'=>[
                    'required' => 'El campo email no esta completo',
                    'min_length'=>'El campo email solo acepta un minimo de 4 caracteres',
                    'max_length'=>'El campo email solo acepta un maximo de 100 caracteres',
                    'valid_email'=> 'El email es invalido',
            ]
        ], 
           
            'mensaje' =>[
              'rules'=>'required',
              'errors'=> [
                'required' => 'Este campo no puede estar vacio'
              ]
              ],
            
        ]);
        $formModel = new FormModel();
 
        if (!$input) {
            $dato['titulo']='Contacto';
            echo view('header',$dato);
           echo view('panel');
            echo view('back/usuario/contact_form',['validation' => $this->validator]);
            echo view('footer2');
        } else {
            $formModel->save([
                'nombre' => $this->request->getVar('nombre'),
                'email'  => $this->request->getVar('email'),
                
                'mensaje' => $this->request->getVar('mensaje'),
                'asunto'  => $this->request->getVar('asunto'),
                'estado' => 'Pendiente',
            ]);          
            session()->setFlashdata('msg','Mensaje Enviado con éxito! Nos pondremos en contacto pronto.');
            //return $this->response->redirect(site_url('/panel'));
            return redirect()->to(base_url('contact-form'));
        }
    }
}