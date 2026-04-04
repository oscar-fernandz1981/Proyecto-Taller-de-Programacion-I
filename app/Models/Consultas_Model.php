<?php
namespace App\Models;
use CodeIgniter\Model;

class Consultas_Model extends Model {
    protected $table = 'consultas'; // Cambialo por el nombre real de tu tabla
    protected $primaryKey = 'id_consulta';
    protected $allowedFields = ['nombre', 'email', 'mensaje', 'fecha', 'leido']; // Ajustá según tus columnas
}