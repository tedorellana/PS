<?php  
//iff(!defined('BASEPATH')) exit ('NO direct script acces allowed');	
class M_proyecto_sql extends CI_Model{

	public function __construct(){
		//$this->db_b = $this->load->database('prueba',TRUE);
	}

	public function insertarProyecto($data){
		$this->db_b->insert('t_proyecto', $data); 
	}

	public function getProyectos(){
		$this->db_b->select('*');
		$this->db_b->from('t_proyecto');
		$query = $this->db_b->get();
		if(empty($query)){
	    	return false;
	    }else{
	    	return $query->result_array();
	    }
	}


	
	
}

?>