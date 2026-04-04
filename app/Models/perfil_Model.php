<?php
namespace App\Models;
use CodeIgniter\Model;


class perfil_Model extends Model{
    protected $table='perfiles';
    protected $primaryKey='id_perfil';
    protected $allowedFields=['descripcion'];
}