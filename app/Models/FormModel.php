<?php 
namespace App\Models;
use CodeIgniter\Model;
class FormModel extends Model
{
	
    protected $table = 'consultas';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'email','mensaje','estado'];

    public function getConsulta($id){

    	return $this->where('id',$id)->first($id);
    }

    public function updateConsulta($id,$datos){

    	return $this->update($id,$datos);
    }

    public function getConsultas($estado){

    	return $this->where('estado',$estado)->findAll();
    }

}