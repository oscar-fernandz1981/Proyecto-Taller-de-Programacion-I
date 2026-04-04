<?php
namespace App\Models;
use CodeIgniter\Model;

class usuario_Model extends Model
{
    protected $table='usuarios';
    protected $primaryKey='id_usuario';
    protected $allowedFields=['nombre','apellido','usuario','email','dni','pass','perfil_img','perfil_id','baja'];


    public function getUsuario($id_usuario){
        return $this->where('id_usuario',$id_usuario)->first($id_usuario);
    }

    public function updateDatos($id_usuario,$datos){
        return $this->update($id_usuario,$datos);
    }

    public function getUsBaja($baja){
        return $this->where('baja',$baja)->findAll();
    }


}