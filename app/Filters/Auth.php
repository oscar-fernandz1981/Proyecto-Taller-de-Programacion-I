<?php
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        
        // Verificar si está logueado
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('msg', 'Debe iniciar sesión para acceder a esta página');
        }

        // Si se especifican perfiles en los argumentos
        if (!empty($arguments)) {
            $perfilUsuario = $session->get('perfil_id');
            
            // Verificar si el perfil del usuario está en los permitidos
            if (!in_array($perfilUsuario, $arguments)) {
                $mensaje = $this->getMensajePermiso($perfilUsuario);
                
                // Redirigir según perfil
                /*
                if ($perfilUsuario == 1) {
                    return redirect()->to('/admin/productos')->with('msg', $mensaje);
                } else {
                    return redirect()->to('/panel')->with('msg', $mensaje);
                }*/
                if ($perfilUsuario == 1) {
                 // CORRECCIÓN: Apuntar a la ruta /panel, no a /admin/productos
                return redirect()->to('/panel')->with('msg', $mensaje);
                } else {
                    return redirect()->to('/panel')->with('msg', $mensaje);
                }
            }
        }

        return $request;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return $response;
    }

    private function getMensajePermiso($perfil)
    {
        if ($perfil == 1) {
            return 'Acceso denegado. Esta sección es solo para clientes.';
        } else {
            return 'Acceso denegado. Se requiere permisos de administrador.';
        }
    }
}