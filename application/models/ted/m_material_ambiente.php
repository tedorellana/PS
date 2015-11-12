<?php 

class M_material_ambiente extends CI_Model{
	public function __construct(){
		$this->load->database();
	}

	public function getMaterialesAmbiente($idProyecto,$idAmbienteFantasma){
		// AMBIENTE FANTASMA E ACTIVIDAD FANTASMA
		//NECESARIO TENER AGREGADO POZO EN LA TABLA AMBIENTE_ACTIVIDAD_MATERIAL 1 actividad pozo por AMBIENTE
		$query = $this->db->query('select * from t_proyecto,t_ambiente,t_actividad,t_ambiente_actividad,t_ambiente_actividad_material,t_material where t_material.idMaterial=t_ambiente_actividad_material.fk_idMaterial
			and t_ambiente_actividad.idAmbiente_actividad=t_ambiente_actividad_material.fk_idAmbienteActividad and t_ambiente_actividad.fk_idAmbiente=t_ambiente.idAmbiente and t_ambiente_actividad.fk_idActividad=t_actividad.idActividad
			and t_proyecto.idProyecto= t_ambiente.fk_idProyecto and t_proyecto.idProyecto ='.$idProyecto.' and t_ambiente.idAmbiente != '.$idAmbienteFantasma.' and t_actividad.idActividad = 1');
		
		if(empty($query)){
	    	return false;
	    }else{
	    	return $query->result_array();
	    }
	}

	public function getActividadFantasmaPorAmbienteMaterial($idProyecto,$idAmbienteFantasma,$idMaterial){
		$query = $this->db->query('select idAmbienteActividadMaterial,idAmbiente_actividad from t_proyecto,t_ambiente,t_actividad,t_ambiente_actividad,t_ambiente_actividad_material,t_material where t_material.idMaterial=t_ambiente_actividad_material.fk_idMaterial
			and t_ambiente_actividad.idAmbiente_actividad=t_ambiente_actividad_material.fk_idAmbienteActividad and t_ambiente_actividad.fk_idAmbiente=t_ambiente.idAmbiente and t_ambiente_actividad.fk_idActividad=t_actividad.idActividad
			and t_proyecto.idProyecto= t_ambiente.fk_idProyecto and t_proyecto.idProyecto ='.$idProyecto.' and t_ambiente.idAmbiente != '.$idAmbienteFantasma.' and idMaterial ='.$idMaterial.' and t_actividad.idActividad = 1');
		if(empty($query)){
	    	return false;
	    }else{
	    	return $query->result_array();
	    }
	}

	public function getActividadFantasmaPorAmbiente($idProyecto,$idAmbienteFantasma){
		$query = $this->db->query('select idAmbiente_actividad from t_proyecto,t_ambiente,t_actividad,t_ambiente_actividad where t_ambiente_actividad.fk_idAmbiente=t_ambiente.idAmbiente and t_ambiente_actividad.fk_idActividad=t_actividad.idActividad
			and t_proyecto.idProyecto= t_ambiente.fk_idProyecto and t_proyecto.idProyecto = '.$idProyecto.' and t_ambiente.idAmbiente != '.$idAmbienteFantasma.' and t_actividad.idActividad = 1');
		if(empty($query)){
	    	return false;
	    }else{
	    	return $query->result_array();
	    }
	}

	public function recuperaPozo($data,$idProyecto){
		$query = $this->db->query('select idAmbiente_actividad from	t_proyecto,t_ambiente,t_actividad,t_ambiente_actividad where t_ambiente_actividad.fk_idAmbiente=t_ambiente.idAmbiente 
									and t_ambiente_actividad.fk_idActividad=t_actividad.idActividad
									and t_proyecto.idProyecto= t_ambiente.fk_idProyecto 	
									and t_ambiente_actividad.fk_idActividad = 1 and 
									t_ambiente_actividad.fk_idAmbiente = '. $data.'
									and t_proyecto.idProyecto= '.$idProyecto );
		if(empty($query)){
	    	return false;
	    }else{
	    	return $query->result_array();
	    }
	}

	public function cantMatAsignadaAmbiente($data){
		$query = $this->db->query('select cantDispActividad_material from  t_ambiente_actividad_material,t_material,t_proyecto,t_ambiente,t_actividad,t_ambiente_actividad 
									where  t_ambiente_actividad.idAmbiente_actividad =  t_ambiente_actividad_material.fk_idAmbienteActividad
									and t_material.idMaterial = t_ambiente_actividad_material.fk_idMaterial
									and t_ambiente_actividad.fk_idAmbiente=t_ambiente.idAmbiente 
									and t_ambiente_actividad.fk_idActividad=t_actividad.idActividad
									and t_proyecto.idProyecto= t_ambiente.fk_idProyecto 	
									and t_ambiente_actividad_material.fk_idMaterial = '. $data['idMaterial'].'
									and t_ambiente_actividad_material.fk_idAmbienteActividad = '. $data['fk_idAmbiente_Actividad'].'
									and t_proyecto.idProyecto= '.$data['idProyecto'] );
		$this->db->last_query();
		if(empty($query)){
	    	return false;
	    }else{
	    	return $query->result_array();
	    }
	}
	public function cantMatDispProy($data,$idAmbienteFantasma,$idProyecto){
		$query = $this->db->query('select cantDispActividad_material from  t_ambiente_actividad_material,t_material,t_proyecto,t_ambiente,t_actividad,t_ambiente_actividad 
									where  t_ambiente_actividad.idAmbiente_actividad =  t_ambiente_actividad_material.fk_idAmbienteActividad
									and t_material.idMaterial = t_ambiente_actividad_material.fk_idMaterial
									and t_ambiente_actividad.fk_idAmbiente=t_ambiente.idAmbiente 
									and t_ambiente_actividad.fk_idActividad=t_actividad.idActividad
									and t_proyecto.idProyecto= t_ambiente.fk_idProyecto 	
									and t_ambiente_actividad_material.fk_idMaterial = '. $data.'
									and t_ambiente_actividad_material.fk_idAmbienteActividad = '.$idAmbienteFantasma.'
									and t_proyecto.idProyecto= ' .$idProyecto );
		echo $this->db->last_query();
		if(empty($query)){
	    	return false;
	    }else{
	    	return $query->result_array();
	    }
	}

	public function retiraRecursoParaAsignacion($data){
		$this->db->where('fk_idMaterial',$data['idMaterial']);
		$this->db->where('fk_idAmbienteActividad',$data['fk_idAmbienteActividad']);
		$this->db->update('t_ambiente_actividad_material',array('cantDispActividad_material' => $data['cantDispActividad_material']));

	}

	public function asiganaMaterialAmbiente($data){
		$this->db->where('fk_idMaterial',$data['idMaterial']);
		$this->db->where('fk_idAmbienteActividad',$data['fk_idAmbienteActividad']);
		$this->db->update('t_ambiente_actividad_material',array('cantDispActividad_material' => $data['cantDispActividad_material']));
	
	}

	public function incorporaMaterial($data,$idProyectoPozo){
		$this->db->query("insert into t_ambiente_actividad_material (`cantDispActividad_material`,`fk_idMaterial`, `fk_idAmbienteActividad`) VALUES ('".$data['cantidad']."','".$data['idMaterial']."', '".$idProyectoPozo."')");
	}

	public function creaActividadInicializada($idAmbiente){
		$this->db->query("insert into t_ambiente_actividad (`agregado`,`fk_idAmbiente`, `fk_idActividad`) VALUES ( '1','".$idAmbiente."', '1')");
		return mysql_insert_id();
	}
	public function creaMaterialInicial($cantidad,$existePozoEnAmbiente,$mat){
		$this->db->query("insert into t_ambiente_actividad_material (`cantDispActividad_material`,`fk_idMaterial`, `fk_idAmbienteActividad`) VALUES ( '".$cantidad."','".$mat."', '".$existePozoEnAmbiente."')");
		echo $this->db->last_query();
	}

	
}

?>